@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('public/frontend') }}/css/countrySelect.css">
@endpush

@section('content')
    <section class="login ptb-80">
        <div class="container">
            <div class="registion-section-area">
                <div class="register-header text-center pb-30">
                    <h2 class="title">{{ @$page_title }}</h2>
                </div>
                <form action="{{ route('nanny.register.submit') }}" method="POST">
                    @csrf
                    <div class="d-flex">
                        <div class="form-group w-50 pe-3">
                            @include('admin.components.form.input', [
                                'label' => 'First Name*',
                                'name' => 'firstname',
                                'placeholder' => 'First Name',
                                'value' => old('firstname'),
                                'required' => 'required',
                            ])
                        </div>
                        <div class="form-group w-50">
                            @include('admin.components.form.input', [
                                'label' => 'Last Name*',
                                'name' => 'lastname',
                                'placeholder' => 'Last Name',
                                'value' => old('lastname'),
                                'required' => 'required',
                            ])
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="form-group w-50 pe-3">
                            <label>{{ __('Mobile') }}<span>*</span></label>

                            <input type="text" class="form--control" placeholder="Enter Phone ..." name="mobile"
                                value="{{ old('mobile', auth()->user()->mobile ?? '') }}">
                        </div>
                        <div class="form-group w-50">
                            <label class="">{{ __('Country') }}<span class="">*</span></label>
                            <div class="form-item">
                                <input id="country_selector" name="country" type="text" class="form--control w-100">
                            </div>

                        </div>
                    </div>
                    <div class="d-flex nanny">
                        <div class="form-group w-50 pe-3">
                            @include('admin.components.form.input', [
                                'label' => 'Email*',
                                'type' => 'email',
                                'name' => 'email',
                                'placeholder' => 'Email',
                                'value' => old('email'),
                                'required' => 'required',
                            ])
                        </div>
                        <div class="form-group mb-4 w-50 show_hide_password">
                            <label for="password">{{ __('Password*') }}</label>
                            <input type="password" class="form--control" name="password" placeholder="Password" required>
                            <a href="javascript:void(0)" class="show-pass"><i class="fa fa-eye-slash"
                                    aria-hidden="true"></i></a>
                        </div>
                    </div>

                    <div class="register-btn">
                        <button type="submit" class="btn--base w-100 text-center mt-2">{{ __('Register Now') }}</button>

                    </div>

                </form>



                <div class="register-to-login">
                    <p class="d-block text-center mt-5 create-acc">
                        — {{ __('Already an account?') }}
                        <a href="{{ route('nanny.login') }}">{{ __('Nanny Login') }}</a>
                        —
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script src="{{ asset('public/frontend') }}/js/countrySelect.js"></script>
    <script>
        $("#country_selector").countrySelect({
            defaultCountry: "us",
            responsiveDropdown: true,
        });
    </script>
@endpush
