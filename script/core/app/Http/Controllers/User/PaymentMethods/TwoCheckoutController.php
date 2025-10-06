<?php

namespace App\Http\Controllers\User\PaymentMethods;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\PaymentController;
use App\Models\Post;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TwoCheckoutController extends Controller
{

    /**
     * Process the payment
     *
     * @param  Transaction  $transaction
     */
    public static function pay(Transaction $transaction)
    {
        $checkout_seller_id = config('settings.checkout_account_number');
        $checkout_private_key = config('settings.checkout_private_key');
        $checkout_public_key = config('settings.checkout_public_key');
        $sandbox = config('settings.2checkout_sandbox_mode');

        $color = config('settings.theme_color');

        if ($transaction->transaction_method == 'premium') {
            /* Make Listing Premium Payment */
            $cancel_url = route('transactions');
        } else {
            /* Membership Payment */
            $cancel_url = route('subscription');
        }

        /* display payment gateway form */
        return view(active_theme()."user.gateways.two-checkout", compact('transaction', 'checkout_seller_id', 'checkout_private_key', 'checkout_public_key', 'sandbox', 'color', 'cancel_url'));
    }

    /**
     * Handle the IPN
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public static function ipn(Request $request)
    {
        try {

            $id = $request->get('order_id');

            $transaction = Transaction::where([
                ['id', $id],
                ['status', null],
                ['payment_id', null],
            ])->first();

            if (is_null($transaction)) {
                quick_alert_error(___('Invalid transaction, please try again.'));
                return redirect()->route('transactions');
            }

            $checkout_seller_id = config('settings.checkout_account_number');
            $checkout_private_key = config('settings.checkout_private_key');
            $checkout_public_key = config('settings.checkout_public_key');
            $sandbox = config('settings.2checkout_sandbox_mode');

            $currency = config('settings.currency_code');

            $user = request()->user();
            $address = [
                "name" => user_options($user->id, 'billing_name'),
                "addrLine1" => user_options($user->id, 'billing_address'),
                "city" => user_options($user->id, 'billing_city'),
                "state" => user_options($user->id, 'billing_state'),
                "zipCode" => user_options($user->id, 'billing_zipcode'),
                "country" => user_options($user->id, 'billing_country'),
                "email" => $user->email,
                "phoneNumber" => ''
            ];

            \Twocheckout::privateKey($checkout_private_key); //Private Key
            \Twocheckout::sellerId($checkout_seller_id); // 2Checkout Account Number
            \Twocheckout::verifySSL(false);

            try {

                $data = [
                    "merchantOrderId" => $transaction->id,
                    "token" => $_POST['2checkoutToken'],
                    "currency" => $currency,
                    "total" => $transaction->amount,
                    "billingAddr" => $address,
                    "shippingAddr" => $address
                ];
                if ($sandbox == 'sandbox') {
                    $data['demo'] = true;
                }

                $charge = \Twocheckout_Charge::auth($data);

                if ($charge['response']['responseCode'] == 'APPROVED') {
                    /*Success*/
                    $update = $transaction->update([
                        'transaction_gatway' => 'two_checkout',
                        'status' => Transaction::STATUS_SUCCESS,
                    ]);

                    if ($update) {
                        if ($transaction->transaction_method == 'premium') {
                            /* Order payment */
                            PaymentController::paySuccess($transaction);
                            quick_alert_success(___('Payment successful'));
                        } else {
                            /* Membership Payment */
                            CheckoutController::updateUserPlan($transaction);
                            quick_alert_success(___('Payment successful'));
                        }
                    }
                } else {
                    quick_alert_error(___('Payment failed, please try again.'));
                    return back();
                }

            } catch (\Twocheckout_Error $e) {
                Log::info($e->getMessage());
                quick_alert_error($e->getMessage());
                return back();
            }

        } catch (\Exception $e) {
            Log::info($e->getMessage());
            quick_alert_error(___('Payment failed, please try again.'));
            return back();
        }

        return redirect()->route('transactions');
    }
}
