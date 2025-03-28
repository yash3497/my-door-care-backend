@extends('nanny.layouts.master')

@push('css')
@endpush

@section('content')
    <section class="verification-otp ptb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class=" col-xl-6 col-lg-8 col-md-10 col-sm-12">
                    <div class="verification-otp-area">
                        <div class="account-wrapper-area otp-verification">
                            <div class="account-logo text-center">
                                <a href="{{ route('index') }}" class="site-logo">
                                    <img src="{{ get_logo($basic_settings, 'white') }}" alt="logo">
                                </a>
                            </div>
                            <div class="verification-otp-content ptb-30">
                                <h4 class="title text-center">{{ __('Please enter the 2fa code') }}</h4>

                            </div>
                            <form action="{{ setRoute('nanny.authorize.google.2fa.submit') }}" class="account-form"
                                method="POST">
                                @csrf
                                <div class="row ml-b-20">
                                    <div class="col-lg-12 form-group text-center">
                                        <input class="otp" type="text" name="code[]" oninput='digitValidate(this)'
                                            onkeyup='tabChange(1)' maxlength=1 required>
                                        <input class="otp" type="text" name="code[]" oninput='digitValidate(this)'
                                            onkeyup='tabChange(2)' maxlength=1 required>
                                        <input class="otp" type="text" name="code[]" oninput='digitValidate(this)'
                                            onkeyup='tabChange(3)' maxlength=1 required>
                                        <input class="otp" type="text" name="code[]" oninput='digitValidate(this)'
                                            onkeyup='tabChange(4)' maxlength=1 required>
                                        <input class="otp" type="text" name="code[]" oninput='digitValidate(this)'
                                            onkeyup='tabChange(5)' maxlength=1 required>
                                        <input class="otp" type="text" name="code[]" oninput='digitValidate(this)'
                                            onkeyup='tabChange(6)' maxlength=1 required>
                                    </div>

                                    <div class="col-lg-12 form-group text-center">
                                        <button type="submit" class="btn--base w-100">{{ __('Submit') }}</button>
                                    </div>
                                    <div class="col-lg-12 text-center">
                                        <div class="account-item">
                                            <label>{{ __('Already Have An Account?') }} <a href="{{ route('nanny.login') }}"
                                                    class="account-control-btn">{{ __('Login Now') }}</a></label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('script')
    <script>
        let digitValidate = function(ele) {

            ele.value = ele.value.replace(/[^0-9]/g, '');
        }

        let tabChange = function(val) {
            let ele = document.querySelectorAll('.otp');
            if (ele[val - 1].value != '') {
                ele[val].focus()
            } else if (ele[val - 1].value == '') {
                ele[val - 2].focus()
            }
        }

        $(".otp").parents("form").find("input[type=submit],button[type=submit]").click(function(e) {
         
            var otps = $(this).parents("form").find(".otp");
            var result = true;
            $.each(otps, function(index, item) {
                if ($(item).val() == "" || $(item).val() == null) {
                    result = false;
                }
            });

            if (result == false) {
                $(this).parents("form").find(".otp").addClass("required");
            } else {
                $(this).parents("form").find(".otp").removeClass("required");
                $(this).parents("form").submit();
            }
        });
    </script>
@endpush
