<?php

namespace App\Http\Controllers\User\PaymentMethods;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\PaymentController;
use App\Models\Post;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mollie\Laravel\Facades\Mollie;

class MollieController extends Controller
{

    /**
     * Process the payment
     *
     * @param  Transaction  $transaction
     */
    public static function pay(Transaction $transaction)
    {
        $currency = config('settings.currency_code');
        config(['mollie.key' => config('settings.mollie_api_key')]);

        if ($transaction->transaction_method == 'premium') {
            /* Make Listing Premium Payment */
            $title = "Payment for " . $transaction->transaction_description;
        } else {
            /* Membership Payment */
            $title = "Payment for ".$transaction->product_name." Plan (".$transaction->frequency.')';
        }

        $price = number_format((float) $transaction->amount, 2, '.', '');

        try {
            $mollie = Mollie::api()->payments->create([
                "description" => $title,
                "amount" => ["currency" => $currency, "value" => $price],
                "redirectUrl" => route('ipn', 'mollie').'?order_id='.$transaction->id,
            ]);

            $payment = Mollie::api()->payments()->get($mollie->id);

            $transaction->update(['payment_id' => $payment->id]);

            /* redirect to payment gateway page */
            return redirect($payment->getCheckoutUrl());

        } catch (\Exception $e) {
            Log::info($e->getMessage());
            quick_alert_error($e->getMessage());
            return back()->withInput();
        }
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
                ['payment_id', '!=', null],
            ])->first();

            if (is_null($transaction)) {
                quick_alert_error(___('Invalid transaction, please try again.'));
                return redirect()->route('subscription');
            }

            config(['mollie.key' => config('settings.mollie_api_key')]);

            $mollie = Mollie::api()->payments()->get($transaction->payment_id);

            if ($mollie->status == "paid") {
                $update = $transaction->update([
                    'transaction_gatway' => 'mollie',
                    'payment_id' => $mollie->id,
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
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            quick_alert_error(___('Payment failed, please try again.'));
            return back();
        }

        return redirect()->route('subscription');
    }
}
