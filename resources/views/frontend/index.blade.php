@extends('frontend.layouts.master')

@push('css')
@endpush
@php
    //get selected language
    $lang = selectedLang();
    // Banner
    $banner_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::BANNER_SECTION);
    $banner = App\Models\Admin\SiteSections::getData($banner_slug)->first();
    //Best Care
    $best_care_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::BEST_CARE_SECTION);
    $best_care = App\Models\Admin\SiteSections::getData($best_care_slug)->first();
    //App Download
    $app_download_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::APP_DOWNLOAD_SECTION);
    $app_download = App\Models\Admin\SiteSections::getData($app_download_slug)->first();

    // about
    $about_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::ABOUT_SECTION);
    $about = App\Models\Admin\SiteSections::getData($about_slug)->first();

    $app_setting = App\Models\Admin\AppSettings::first();

@endphp
@section('content')
    <section class="banner bg-overlay bg_img" data-background="{{ asset('public/frontend') }}/images/element/banner-bg.webp">
        <div class="container mx-auto">
            <div class="row">
                <div class=" col-xl-6 col-lg-8 col-md-10 col-12 banner-content my-auto">
                    <h1 class="title">{{ @$banner->value->language->$lang->heading }}</h1>
                    <p>{{ @$banner->value->language->$lang->sub_heading }}</p>
                    <div class="banner-btn">
                        <a href="{{ $banner->value->language->$lang->left_button_link ?? route('nanny.login') }}"
                            class="btn-nanny btn">{{ __('Join As Nanny') }}</a>
                        <a href="{{ $banner->value->language->$lang->right_button_link ?? route('services') }}"
                            class="btn--base btn">{{ __('Get Service') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- about section start --}}
    <section class="happy pt-80 bg_img-2" data-background="{{ asset('public/frontend') }}/images/element/shape1.png">
        <div class="container mx-auto">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12 col-12">
                    <div>
                        <img src="{{ get_image(@$about->value->image, 'site-section') }}" alt="image">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-12 my-auto left-content">
                    <h5 class="sub-top"><i class="las la-paw"></i> {{ @$about->value->language->$lang->sub_heading }}</h5>
                    <h2>{{ @$about->value->language->$lang->heading }}</h2>
                    <p>{{ textLength(strip_tags(@$about->value->language->$lang->description, 50)) }}</p>
                    <div>
                        <a href="{{ @$about->value->language->$lang->button_link ?? route('about') }}"
                            class="btn--base mb-4 mb-lg-0 mb-md-0">{{ @$about->value->language->$lang->button_text }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- about section end --}}
    @include('frontend.components.feature')

    <section class="quality ptb-60">
        <div class="container mx-auto">
            <div class="text-content text-center">
                <h5 class="sub-top"><i class="las la-paw"></i>{{ @$best_care->value->language->$lang->sub_heading }}</h5>
                <h2>{{ @$best_care->value->language->$lang->heading }}</h2>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 thumb-side">
                    <img src="{{ get_image(@$best_care->value->left_image, 'site-section') }}" alt="image">
                </div>
                <div class="col-lg-6 col-md-6 thumb-side">
                    <img src="{{ get_image(@$best_care->value->right_image, 'site-section') }}" alt="image">
                </div>
            </div>
        </div>
    </section>
    {{-- Why choose us  --}}
    @include('frontend.components.why-choose-us')

    @include('frontend.components.blog', compact('blogs'))
    {{-- app-section --}}
    <section class="app-section pt-60">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-12">
                    <div class="app-section-area">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="app-area">
                                    <div class="app-img"> <img
                                            src="{{ get_image(@$app_download->value->image, 'site-section') }}"
                                            alt="img">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 pt-5">
                                <div class="get-app">
                                    <h5 class="sub-top"><i
                                            class="las la-paw"></i>{{ @$app_download->value->language->$lang->sub_heading }}
                                    </h5>
                                    <h2>{{ @$app_download->value->language->$lang->heading }}</h2>
                                    <p>{{ @$app_download->value->language->$lang->description }}</p>
                                </div>
                                <div class="apps-sorch pt-3">
                                    <div class="img-1">
                                        <a href="{{ @$app_setting->iso_url }}"><img
                                                src="{{ asset('public/frontend') }}/images/element/app-store.svg"
                                                alt="app"></a>
                                        <a href="{{ @$app_setting->android_url }}"><img
                                                src="{{ asset('public/frontend') }}/images/element/googlepaly.svg"
                                                alt="app"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
@endpush
