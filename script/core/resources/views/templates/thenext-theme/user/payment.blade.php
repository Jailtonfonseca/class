@extends($activeTheme.'layouts.main')
@section('title', ___('Payment'))
@section('content')
    <div id="titlebar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{___('Payment')}}</h2>
                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs">
                        <ul>
                            <li><a href="{{ route('home') }}">{{ ___('Home') }}</a></li>
                            <li>{{___('Payment')}}</li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- Content -->
            <div class="col-xl-8 col-lg-8 content-right-offset">
                <form id="subscribeForm" action="{{ route('payment.pay', $transaction->id) }}" method="POST">
                    @csrf

                    <h3 class="margin-bottom-30">{{___('Payment Method')}}</h3>

                    @if(\Session::get('quick_alert_message'))
                    <div class="notification error margin-bottom-30">
                        {{ \Session::get('quick_alert_message') }}
                    </div>
                    @endif

                    @if(!empty($paymentGateways))
                        <div class="payment">
                            @foreach ($paymentGateways as $paymentGateway)
                                <div
                                    class="payment-tab @if(old('payment_method') == $paymentGateway->id) payment-tab-active @endif">
                                    <div class="payment-tab-trigger">
                                        <input name="payment_method" id="{{ $paymentGateway->payment_folder }}"
                                               type="radio" value="{{ $paymentGateway->id }}"
                                               data-name="{{ $paymentGateway->payment_folder }}"
                                               @if(old('payment_method') == $paymentGateway->id) checked @endif>
                                        <label
                                            for="{{ $paymentGateway->payment_folder }}">{{ $paymentGateway->payment_title }}</label>
                                        <img class="payment-logo {{ $paymentGateway->payment_folder }}"
                                             src="{{ asset('storage/payment_gateways/'.$paymentGateway->payment_folder.'.png') }}"
                                             alt="{{ $paymentGateway->payment_title }}">
                                    </div>
                                    <div class="payment-tab-content">
                                        @if($paymentGateway->payment_folder == 'paystack')
                                        <div class="row payment-form-row">
                                            <div class="col-6 pull-right">
                                                <div class="card-label form-group">
                                                    <input
                                                        type="email"
                                                        class="form-control"
                                                        name="email"
                                                        id="email"
                                                        placeholder="{{___('Email')}}"
                                                        value="{{ old('email') }}"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                            <p>{{ ___('You will be redirected to the payment page for complete payment.') }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" name="payment_submit"
                                class="button big ripple-effect margin-top-40 margin-bottom-65 subscribeNow"
                                id="subscribeNow">{{ ___('Submit') }}</button>
                    @else
                        <div class="notification error">
                            {{ ___('No payment methods available right now please try again later.') }}
                        </div>
                    @endif
                </form>
            </div>
            <div class="col-xl-4 col-lg-4 margin-top-0 margin-bottom-60">
                <div class="boxed-widget summary margin-top-0">
                    <div class="boxed-widget-headline">
                        <h3>{{ ___('Order Summary') }}</h3>
                    </div>
                    <div class="boxed-widget-inner">
                        <ul>
                            <li>{{ ___('Order') }}
                                <span>{{ $transaction->product_name }}</span>
                            </li>
                            <li>{{ ___('Details') }}
                                <span>{{ $transaction->transaction_description }}</span>
                            </li>
                            <li class="total-costs"></li>
                            <li>{{ ___('Price') }} <span>{{ price_symbol_format($transaction->base_amount) }}</span></li>
                            <li class="total-costs">{{ ___('Total Cost') }} <span>{{ price_code_format($transaction->amount) }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts_at_bottom')
    <script>
        if (!$("input[name='payment_method']:checked").length) {
            $('.payment-tab').first().addClass('payment-tab-active');
            $('[name=payment_method]').first().prop('checked', true).trigger('change');
        }
    </script>
@endpush
