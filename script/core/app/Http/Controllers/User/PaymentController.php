<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use App\Models\Post;
use App\Models\PostOption;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Validator;

class PaymentController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->activeTheme = active_theme();
    }

    /**
     * Display the page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Transaction $transaction)
    {
        $post = Post::find($transaction->product_id);
        if ($post) {
            $paymentGateways = PaymentGateway::where('payment_install', '1')->get();
            return view($this->activeTheme.'.user.payment', compact(
                'transaction',
                'post',
                'paymentGateways'
            ));
        }

        abort(404);
    }

    /**
     * Handle Payment
     *
     * @param  Request  $request
     * @param  Transaction  $transaction
     */
    public function pay(Request $request, Transaction $transaction)
    {
        $post = Post::find($transaction->product_id);

        if ($post) {
            $gateway = PaymentGateway::where('id', $request->get('payment_method'))->firstOrFail();
            $paymentController = __NAMESPACE__.'\PaymentMethods\\'
                .str_replace(
                    ' ', '',
                    ucwords(
                        str_replace('_', ' ', $gateway->payment_folder))
                )
                .'Controller';
            return $paymentController::pay($transaction);
        }

        abort(404);
    }

    /**
     * After payment success
     *
     * @param  Transaction  $transaction
     */
    public static function paySuccess(Transaction $transaction)
    {
        /* mark order as paid */
        $post_id = $transaction->product_id;
        $post = Post::find($post_id);
        if($transaction->details->featured != null){
            $post->update([
                'featured' => $transaction->details->featured,
            ]);
        }
        if($transaction->details->urgent != null){
            $post->update([
                'urgent' => $transaction->details->urgent,
            ]);
        }
        if($transaction->details->highlight != null){
            $post->update([
                'highlight' => $transaction->details->highlight,
            ]);
        }
    }
}
