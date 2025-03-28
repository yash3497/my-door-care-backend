@extends('layouts.master')

@push('css')
@endpush

@section('content')
  
    <section class="forgot-password ptb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <div class="forgot-password-area">
                        <div class="account-wrapper-area">
                            <div class="account-logo text-center">
                                <a href="{{ route('index') }}" class="site-logo">
                                    <img src="{{ get_logo($basic_settings) }}" alt="logo">
                                </a>
                            </div>
                            <div class="forgot-password-content ptb-30">
                                <h3 class="title">{{ __('Forget Password?') }}</h3>
                                <p>{{ __("Enter your email and we'll send you a otp to reset your password.") }}</p>
                            </div>
                            <form action="{{ setRoute('user.password.forgot.send.code') }}" class="account-form"
                                method="POST">
                                @csrf
                                <div class="row ml-b-20">
                                    <div class="col-lg-12 form-group">
                                        @include('admin.components.form.input', [
                                            'name' => 'credentials',
                                            'placeholder' => 'Email Address',
                                            'required' => true,
                                        ])
                                    </div>

                                    <div class="col-lg-12 form-group text-center">
                                        <button type="submit" class="btn--base w-100">{{ __('Send OTP') }}</button>
                                    </div>


                                    <div class="col-lg-12 text-center">
                                        <div class="account-item">
                                            <label>{{ __('Already Have An Account?') }} <a href="{{ route('user.login') }}"
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
@endpush
