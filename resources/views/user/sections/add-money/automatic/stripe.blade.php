@extends('user.layouts.master')

@push('css')
    <style>
        .jp-card .jp-card-back,
        .jp-card .jp-card-front {

            background-image: linear-gradient(160deg, #64CDCE 0%, #FD9F16 100%) !important;
        }

        label {
            color: #000000 !important;
        }

        .form--control {
            color: #000000 !important;
        }

        .input-group-text {
            border: none;
            font-size: 14px;
            background: #EFF0F0;
            color: #0f1514;
            height: 65px;
            border-radius: 0 5px 5px 0;
        }

        .form-control:focus {
            -webkit-box-shadow: none;
            box-shadow: none;
            border: 1px solid rgba(253, 161, 22, 0.6);
        }

        .form--control {
            background-color: transparent;
            border: 1px solid rgba(253, 161, 22, 0.6);
            -webkit-box-shadow: none;
            box-shadow: none;
            height: 65px;
            font-size: 14px;
            color: #858687;
            border-radius: 10px;
            padding: 15px 25px;
            width: 100%;
        }

        .form--control:focus {
            background-color: transparent;
            border: 2px solid rgba(253, 161, 22, 0.6);
            -webkit-box-shadow: none;
            box-shadow: none;
            color: #000000;
        }

        .input-group input {
            border-radius: 5px 0 0 5px !important;
            border: 1px solid rgba(253, 161, 22, 0.6);
            color: #000000;
            height: 65px;
        }

        .card {
            background-color: #ffffff;
        }

        .custom--card {
            border: 2px solid #b1b1b1;
        }

        .input-group-text {
            color: #ffffff;
        }
    </style>
@endpush

@section('breadcrumb')
    @include('user.components.breadcrumb', [
        'breadcrumbs' => [
            [
                'name' => __('Dashboard'),
                'url' => setRoute('user.dashboard'),
            ],
        ],
        'active' => __('Stripe Payment'),
    ])
@endsection

@section('content')

    <div class="body-wrapper">
        <div class="card custom--card h-100">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title">@lang('Stripe Payment')</h5>
                <a class="btn btn--danger rounded text-light"
                    href="{{ setRoute('user.add.money.payment.cancel', @$hasData->type) }}">Cancel</a>
            </div>
            <div class="card-body">

                <div class="card-wrapper"></div>
                <br><br>

                <form role="form" id="payment-form" action="{{ setRoute('user.add.money.stripe.payment.confirmed') }}"
                    method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name" class="form--label">@lang('Name on Card')</label>
                            <div class="input-group">
                                <input type="text" class=" form--control custom-input" name="name" autocomplete="off"
                                    autofocus required />
                                <span class="input-group-text bg--base"><i class="fa fa-font"></i></span>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <label for="cardNumber" class="form--label">@lang('Card Number')</label>
                            <div class="input-group">
                                <input type="tel" class=" form--control custom-input" name="cardNumber"
                                    autocomplete="off" required autofocus required />
                                <span class="input-group-text bg--base"><i class="fa fa-credit-card"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <label for="cardExpiry" class="form--label">@lang('Expiration Date')</label>
                            <input type="tel" class=" form--control input-sz custom-input" name="cardExpiry"
                                autocomplete="off" required />
                        </div>
                        <div class="col-md-6 ">
                            <label for="cardCVC" class="form--label">@lang('CVC Code')</label>
                            <input type="tel" class=" form--control input-sz custom-input" name="cardCVC"
                                autocomplete="off" required />
                        </div>
                    </div>
                    <br>
                    <button class="btn--base w-100 text-center btn-loading my-3" type="submit">
                        @lang('PAY NOW') ( {{ number_format(@$hasData->data->amount->total_amount, 2) }}
                        {{ @$hasData->data->amount->sender_cur_code }} )
                    </button>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('public/frontend/') }}/js/card.js"></script>

    <script>
        (function($) {
            "use strict";
            var card = new Card({
                form: '#payment-form',
                container: '.card-wrapper',
                formSelectors: {
                    numberInput: 'input[name="cardNumber"]',
                    expiryInput: 'input[name="cardExpiry"]',
                    cvcInput: 'input[name="cardCVC"]',
                    nameInput: 'input[name="name"]'
                }
            });
        })(jQuery);
    </script>
    <script>
        $('.cancel-btn').click(function() {
            var dataHref = $(this).data('href');
            if (confirm("Are you sure?") == true) {
                window.location.href = dataHref;
            }
        });
    </script>
@endpush
