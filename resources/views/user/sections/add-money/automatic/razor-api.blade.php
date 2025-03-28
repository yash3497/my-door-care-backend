@extends('user.layouts.user_auth')

@push('css')
    <style>
        .razorpay-payment-button {
            display: none;
        }

        .razor-pay .rajor-pay-area .razor-account-wrapper {
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #FF597B;
            border-radius: 10px;
        }

        .dash-payment-title-area {
            display: flex;
            align-items: center;
        }

        .razor-account-wrapper .account-logo {
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .dash-payment-title-area .dash-payment-badge {
            width: 25px;
            height: 25px;
            background-color: #ff597b;
            border-radius: 50%;
            margin-right: 10px;
            color: #ffffff;
            text-align: center;

        }
    </style>
@endpush

@section('content')
    <section class="razor-pay ptb-80">
        <div id="body-overlay" class="body-overlay"></div>
        <div class="container">
            <div class="rajor-pay-area">
                <div class="row justify-content-center">
                    <div class="col-lg-9 col-md-10">
                        <div class="razor-account-wrapper">
                            <div class="account-logo text-center">
                                <a href="{{ setRoute('index') }}" class="site-logo">
                                    <img src="{{ get_logo($basic_settings) }}"
                                        data-white_img="{{ get_logo($basic_settings, 'white') }}"
                                        data-dark_img="{{ get_logo($basic_settings, 'dark') }}" alt="site-logo">
                                </a>
                            </div>
                            <h4 class="title text-center">{{ $page_title }}</h4>
                            <div class="dash-payment-item-wrapper">
                                <div class="dash-payment-item active">
                                    <div class="dash-payment-title-area">
                                        <span class="dash-payment-badge">!</span>
                                        <h5 class="title">{{ _('Payment Information') }}</h5>
                                    </div>
                                    <div class="dash-payment-body">
                                        <div class="preview-list-wrapper">
                                            <div class="preview-list-item">
                                                <div class="preview-list-left">
                                                    <div class="preview-list-user-wrapper">
                                                        <div class="preview-list-user-icon">
                                                            <i class="las la-receipt"></i>
                                                        </div>
                                                        <div class="preview-list-user-content">
                                                            <span>{{ __('Entered Amount') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="preview-list-right">
                                                    <span
                                                        class="request-amount">{{ get_amount(@$output->data->amount->requested_amount, @$output->data->amount->default_currency, 4) }}</span>
                                                </div>
                                            </div>
                                            <div class="preview-list-item">
                                                <div class="preview-list-left">
                                                    <div class="preview-list-user-wrapper">
                                                        <div class="preview-list-user-icon">
                                                            <i class="las la-exchange-alt"></i>
                                                        </div>
                                                        <div class="preview-list-user-content">
                                                            <span>{{ __('Exchange Rate') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="preview-list-right">
                                                    <span class="request-amount">{{ __('1') }}
                                                        {{ get_default_currency_code() }}
                                                        =
                                                        {{ get_amount(@$output->data->amount->sender_cur_rate, @$output->data->amount->sender_cur_code, 4) }}</span>
                                                </div>
                                            </div>
                                            <div class="preview-list-item">
                                                <div class="preview-list-left">
                                                    <div class="preview-list-user-wrapper">
                                                        <div class="preview-list-user-icon">
                                                            <i class="las la-battery-half"></i>
                                                        </div>
                                                        <div class="preview-list-user-content">
                                                            <span>{{ __('Total Fees & Charges') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="preview-list-right">
                                                    <span
                                                        class="fees">{{ get_amount(@$output->data->amount->total_charge, @$output->data->amount->sender_cur_code, 4) }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="preview-list-item">
                                                <div class="preview-list-left">
                                                    <div class="preview-list-user-wrapper">
                                                        <div class="preview-list-user-icon">
                                                            <i class="las la-money-check-alt"></i>
                                                        </div>
                                                        <div class="preview-list-user-content">
                                                            <span class="last">{{ __('Total Payable Amount') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="preview-list-right">
                                                    <span
                                                        class="text--warning last pay-in-total">{{ get_amount(@$output->data->amount->total_amount, @$output->data->amount->sender_cur_code, 4) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('api.v1.api.razor.callback') }}" method="GET">
                                <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="{{ $data->public_key }}"
                                    data-amount="{{ floatval($output->data->amount->total_amount) * 100 }}"
                                    data-currency={{ @$output->data->amount->sender_cur_code ?? 'INR' }} data-name="{{ $basic_settings->site_name }}"
                                    data-description="Add Money" data-image={{ get_fav($basic_settings) }} data-prefill.name="{{ $data->user_name }}"
                                    data-prefill.email="{{ $data->user_email }}" data-theme.color="#F37254"></script>

                                <input type="hidden" value="{{ $orderId }}" name="razorpay_order_id">
                                <input type="hidden" value="{{ @$output->data->amount->sender_cur_code ?? 'INR' }}"
                                    name="razorpay_currency">
                                <input type="hidden" value="{{ floatval($output->data->amount->total_amount) * 100 }}"
                                    name="razorpay_amount">
                                <input type="hidden" value="{{ $basic_settings->site_name }}"
                                    name="razorpay_merchant_name">
                                <input type="hidden" value="Payment for Order ID: {{ $orderId }}"
                                    name="razorpay_description">
                                <input type="hidden" value="{{ setRoute('user.add.money.razor.cancel', $orderId) }}"
                                    name="razorpay_cancel_url">
                                <button type="submit" class="btn--base mt-20 w-100">{{ __('Pay Now') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
                                                                                                End acount
                                                                                            ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

    <ul class="bg-bubbles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
@endsection

@push('script')
    <script></script>
@endpush
