@extends('nanny.layouts.master')

@push('css')
    <style>
        .input-group input {
            height: 50px;
        }
    </style>
@endpush

@section('content')
    <div class="body-wrapper ">

        @include('user.components.welcome')

        <div class="card-area mt-30 pb-120">
            <div class="row justify-content-center mb-20-none">
                <div class="col-lg-6 col-md-6 col-12 mb-20">
                    <div class="card custom--card">
                        <div class="user-text">
                            <h4>{{ __('Two Factor Authenticator') }}</h4>
                        </div>
                        <div class="card-body">
                            <form class="card-form">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 form-group">
                                        <label>{{ __('Two Factor Authenticator') }}<span>*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form--control" id="referralURL"
                                                value="{{ auth()->user()->two_factor_secret }}" readonly>
                                            <div class="input-group-text copytext" id="copyBoard"><i
                                                    class="las la-copy"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 form-group">
                                        <div class="qr-code-thumb text-center">
                                            <img class="mx-auto" src="{{ $qr_code }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12">
                                    @if (auth()->user()->two_factor_status)
                                        <button type="button"
                                            class="btn--base bg--warning w-100 active-deactive-btn">{{ __('Disable') }}</button>
                                        <br>
                                        <div class="text--danger mt-3">
                                            {{ __("Don't forget to add this application in your google authentication app. Otherwise you can't login in your account.") }}
                                        </div>
                                    @else
                                        <button type="button"
                                            class="btn--base w-100 active-deactive-btn">{{ __('Enable') }}</button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12 mb-20">
                    <div class="card custom--card">
                        <div class="user-text">
                            <h4>{{ __('Google Authenticator') }}</h4>
                        </div>


                        <div class="card-body">
                            <h5 class="mb-3">{{ __('Download Google Authenticator App') }}</h5>
                            <p>{{ __('Google Authenticator is a product based authenticator by Google that executes two-venture confirmation administrations for verifying clients of any programming applications.') }}
                                <a href="https://support.google.com/accounts/answer/1066447?hl=en&co=GENIE.Platform=Android"
                                    class="text--base" target="_blanck">{{ __('How to setup?') }}</a>
                            </p>
                            <div class="paly-store-thumb">
                                <img src="{{ asset('public/frontend') }}/images/element/google-authenticator.webp"
                                    alt="img">
                            </div>
                            <div class="card-btn pt-4">
                                <a class="btn--base w-100"
                                    href="{{ $app_setting->android_url }}">{{ __('Download For Android') }}</a>
                                <a class="btn--base mt-10 w-100"
                                    href="{{ $app_setting->android_url }}">{{ __('Download For IOS') }}</a>
                            </div>
                        </div>




                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(".active-deactive-btn").click(function() {
            var actionRoute = "{{ setRoute('nanny.security.google.2fa.status.update') }}";
            var target = 1;
            var btnText = $(this).text();
            var message =
                `Are you sure to <strong>${btnText}</strong> 2 factor authentication (Powered by google)?`;
            openAlertModal(actionRoute, target, message, btnText, "POST");
        });
        $('.copytext').on('click', function() {
            var copyText = document.getElementById("referralURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");

            throwMessage('success', ["Copied: " + copyText.value]);
        });
    </script>
@endpush
