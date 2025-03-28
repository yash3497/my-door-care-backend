<section class="account">
    <div class="account-area">
        <div class="account-wrapper change-form">
            <span class="account-cross-btn"></span>
            <div class="account-logo text-center">
                <a href="{{ setRoute('index') }}" class="site-logo">
                    <img src="{{ get_logo($basic_settings, 'dark') }}" alt="logo">
                </a>
            </div>
            <h3 class="title">{{ __('Log in and Stay Connected') }}</h3>
            <p>{{ __('Our secure login process ensures the confidentiality of your information. Log in today and stay connected to your account, anytime and anywhere.') }}
            </p>

            <form action="{{ setRoute('user.login.submit') }}" class="account-form" method="POST">
                @csrf
                <div class="row ml-b-20">
                    <div class="col-lg-12 form-group">
                        @include('admin.components.form.input', [
                            'name' => 'credentials',
                            'placeholder' => 'Email',
                            'required' => true,
                        ])
                    </div>
                    <div class="col-lg-12 form-group" id="show_hide_password">
                        <input type="password" class="form-control form--control" name="password" placeholder="Password"
                            required>
                        <a href="javascript:void(0)" class="show-pass"><i class="fa fa-eye-slash"
                                aria-hidden="true"></i></a>
                    </div>
                    <div class="col-lg-12 form-group">
                        <div class="forgot-item">
                            <label><a href="{{ setRoute('user.password.forgot') }}"
                                    class="text--base">{{ __('Forgot Password?') }}</a></label>
                        </div>
                    </div>
                    <div class="col-lg-12 form-group text-center">
                        <button type="submit" class="btn--base w-100">{{ __('Login Now') }}</button>
                    </div>

                    @if ($basic_settings->user_registration == 1)
                        <div class="col-lg-12 text-center">
                            <div class="account-item mt-10">
                                <label>{{ __("Don't Have An Account?") }} <a href="javascript:void(0)"
                                        class="text--base account-control-btn">{{ __('Register Now') }}</a></label>
                            </div>
                        </div>
                    @endif
                </div>
            </form>
        </div>
        <div class="account-wrapper">
            <span class="account-cross-btn"></span>
            <div class="account-logo text-center">
                <a class="site-logo" href="{{ setRoute('index') }}"><img src="{{ get_logo($basic_settings, 'dark') }}"
                        alt="logo"></a>
            </div>
            <h3 class="title">{{ __('Register for an Account Today') }}</h3>
            <p>{{ __('Become a part of our community by registering for an account today. Enjoy a range of benefits and features tailored to meet your needs. Our registration page makes it easy to create your account, providing a seamless and user-friendly experience.') }}
            </p>

            <form action="{{ setRoute('user.register.submit') }}" class="account-form" method="POST">
                @csrf
                <div class="row ml-b-20">
                    <div class="col-lg-6 form-group">
                        @include('admin.components.form.input', [
                            'name' => 'firstname',
                            'placeholder' => 'First Name',
                            'value' => old('firstname'),
                            'required' => 'required',
                        ])
                    </div>
                    <div class="col-lg-6 form-group">
                        @include('admin.components.form.input', [
                            'name' => 'lastname',
                            'placeholder' => 'Last Name',
                            'value' => old('lastname'),
                            'required' => 'required',
                        ])
                    </div>
                    <div class="col-lg-12 form-group">
                        @include('admin.components.form.input', [
                            'type' => 'email',
                            'name' => 'email',
                            'placeholder' => 'Email',
                            'value' => old('email'),
                            'required' => 'required',
                        ])
                    </div>
                    <div class="col-lg-12 form-group" id="show_hide_password">
                        <input type="password" class="form--control" name="password" placeholder="Password" required>
                        <a href="javascript:void(0)" class="show-pass"><i class="fa fa-eye-slash"
                                aria-hidden="true"></i></a>

                    </div>
                    @if ($basic_settings->agree_policy == true)
                        <div class="col-lg-12 form-group">
                            <div class="custom-check-group mb-0">
                                <input type="checkbox" id="level-1" name="agree">
                                <label for="level-1" class="mb-0">{{ __('I have agreed with') }} <a href="#0"
                                        class="text--base">{{ __('Terms Of Use & Privacy Policy') }}</a></label>
                            </div>
                          
                        </div>
                    @endif

                    <div class="col-lg-12 form-group text-center">
                        <button type="submit" class="btn--base w-100">{{ __('Register Now') }}</button>
                    </div>
                    <div class="col-lg-12 text-center">
                        <div class="account-item mt-10">
                            <label>{{ __('Already Have An Account?') }} <a href="javascript:void(0)"
                                    class="text--base account-control-btn">{{ _('Login Now') }}</a></label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
