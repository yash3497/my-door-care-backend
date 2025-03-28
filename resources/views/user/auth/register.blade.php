@extends('frontend.layouts.master')
@php
    $current_route_name = Route::currentRouteName();
    //get selected language
    $lang = selectedLang();
    // Banner
    $user_register_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::USER_REGISTER);
    $user_register = App\Models\Admin\SiteSections::getData($user_register_slug)->first();
@endphp
@push('css')
    <link rel="stylesheet" href="{{ asset('public/frontend') }}/css/countrySelect.css">
@endpush

@section('content')
    <section class="login ptb-80">
        <div class="container">
            <div class="row mb-20-none">
                <div class="col-lg-6 mb-20">
                    <div class="content">
                        <div class="my-4">
                            <h3 class="pb-2 text-capitalize fw-bold">{{ @$user_register->value->language->$lang->heading }}
                            </h3>
                        </div>
                        <form action="{{ route('user.register.submit') }}" method="POST">
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
                                        'label' => 'Last Name',
                                        'name' => 'lastname',
                                        'placeholder' => 'Last Name',
                                        'value' => old('lastname'),
                                        'required' => 'required',
                                    ])
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="form-group w-50 pe-3">
                                    <label class="">{{ __('Country') }}<span class="">*</span></label>
                                    <div class="form-item">
                                        <input id="country_selector" value="{{ old('country') }}" name="country"
                                            type="text" class="form--control w-100">
                                    </div>
                                </div>
                                <div class="form-group w-50">
                                    <label for="service_area">{{ __('City') }} <span class="">*</span></label>
                                    <select class="nice-select select-area py-0 w-100" id="service_area" name="city">
                                        <option selected disabled>Choose One</option>
                                        @if ($service_areas)
                                            @foreach ($service_areas as $service_area)
                                                <option value="{{ $service_area->service_area }}">
                                                    {{ $service_area->service_area }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="form-group w-50 pe-3">
                                    @include('admin.components.form.input', [
                                        'label' => 'State*',
                                        'name' => 'state',
                                        'placeholder' => 'Enter State...',
                                        'value' => old('address'),
                                    ])
                                </div>
                                <div class="form-group w-50">
                                    @include('admin.components.form.input', [
                                        'label' => 'Address*',
                                        'name' => 'address',
                                        'placeholder' => 'Enter Address...',
                                        'value' => old('address'),
                                    ])
                                </div>
                            </div>
                            <div class="form-group ">
                                @include('admin.components.form.input', [
                                    'label' => 'Email*',
                                    'type' => 'email',
                                    'name' => 'email',
                                    'placeholder' => 'Email',
                                    'value' => old('email'),
                                    'required' => 'required',
                                ])
                            </div>
                            <div class="form-group mb-4 show_hide_password">
                                <label for="password">{{ __('Password') }}*</label>
                                <input type="password" class="form--control" name="password" placeholder="Password"
                                    required>
                                <a href="javascript:void(0)" class="show-pass show-pass-register"><i class="fa fa-eye-slash"
                                        aria-hidden="true"></i></a>
                            </div>
                            @if ($agree_policy == 1)
                                <div class="col-lg-12 form-group">
                                    <div class="custom-check-group mb-0">
                                        <input type="checkbox" id="level-1" name="agree">
                                        <label for="level-1" class="mb-0">{{ __('I have read agreed with the') }} <a
                                                href="{{ url('link/privacy-policy') }}"
                                                class="text--base">{{ __('Privacy & Policy') }}</a></label>
                                    </div>
                                </div>
                            @endif

                            <button type="submit" class="btn--base w-100 text-center mt-2">{{ __('Register') }}</button>

                            <p class="d-block text-center mt-5 create-acc">
                                — {{ __('Already an account') }}?
                                <a href="{{ route('user.login') }}">{{ __('Login') }}</a>
                                —
                            </p>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 mb-20">
                    <div class="register-img">
                        <img src="{{ get_image(@$user_register->value->image, 'site-section') }}" alt="Image">
                    </div>
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
