@extends('layouts.master')

@push('css')
@endpush

@section('content')
    <div class="new-password ptb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-5">
                    <div class="new-password-area">
                        <div class="account-wrapper-area">
                            <span class="account-cross-btn"></span>
                            <div class="account-logo text-center">
                                <a href="{{ route('index') }}" class="site-logo mb-4">
                                    <img src="{{ get_logo($basic_settings, 'white') }}" alt="logo">
                                </a>
                            </div>
                            <form action="{{ setRoute('user.password.reset', $token) }}" class="account-form new-password"
                                method="POST">
                                @csrf
                                <div class="row ml-b-20">
                                    <div class="col-lg-12 form-group show_hide_password">
                                        @include('admin.components.form.input', [
                                            'name' => 'password',
                                            'type' => 'password',
                                            'placeholder' => 'New Password',
                                            'required' => true,
                                        ])
                                        <a href="javascript:void(0)" class="show-pass"><i class="fa fa-eye-slash"
                                                aria-hidden="true"></i></a>
                                    </div>
                                    <div class="col-lg-12 form-group show_hide_password-2">
                                        @include('admin.components.form.input', [
                                            'name' => 'password_confirmation',
                                            'type' => 'password',
                                            'placeholder' => 'Confirm Password',
                                            'required' => true,
                                        ])
                                        <a href="javascript:void(0)" class="show-pass"><i class="fa fa-eye-slash"
                                                aria-hidden="true"></i></a>
                                    </div>
                                    <div class="col-lg-12 form-group text-center">
                                        <button type="submit" class="btn--base w-100">{{ __('Confirm') }}</button>
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
    </div>
@endsection

@push('script')
@endpush
