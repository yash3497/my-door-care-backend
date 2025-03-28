@extends('frontend.layouts.master')
@php

    $current_route_name = Route::currentRouteName();
    //get selected language
    $lang = selectedLang();
    // Banner
    $login_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::LOGIN);
    $login = App\Models\Admin\SiteSections::getData($login_slug)->first();
@endphp
@section('content')
    <section class="login ptb-40">
        <div class="container mx-auto">
            <div class="row">
                <div class="col-md-6 d-grid my-auto py-5 login-img">
                    <img src="{{ get_image(@$login->value->image, 'site-section') }}" alt="Image" class="img-fluid">
                </div>

                <div class="col-md-6 my-auto">
                    <div class="content">
                        <div class="my-4">
                            <h3 class="pb-2 text-capitalize fw-bold">{{ @$login->value->language->$lang->heading }}
                                {{ $current_route_name == 'nanny.login' ? __('Nanny') : '' }}</h3>
                        </div>
                        <form action="{{ route('nanny.login.submit') }}" method="POST">
                            @csrf
                            <div class="form-group ">
                                @include('admin.components.form.input', [
                                    'name' => 'credentials',
                                    'placeholder' => 'Email Address',
                                    'required' => true,
                                ])

                            </div>
                            <div class="form-group mb-4 show_hide_password">
                                <input type="password" name="password" class="form--control" placeholder="Password">
                                <a href="javascript:void(0)" class="show-pass"><i class="fa fa-eye-slash"
                                        aria-hidden="true"></i></a>
                            </div>
                            <div class="forgot-item">
                                <label><a href="{{ route('nanny.password.forgot') }}"
                                        class="forgot-item-btn account-control-btn"
                                        data-block="forgot">{{ __('Forgot Password?') }}</a></label>
                            </div>
                            <button type="submit" class="btn--base w-100 text-center mt-2">{{ __('Login') }}</button>

                            <p class="d-block text-center mt-5 create-acc">
                                — {{ __("Don't have an account") }}?
                                <a href="{{ route('nanny.register') }}">{{ __('Register') }}</a>
                                —
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
@endpush
