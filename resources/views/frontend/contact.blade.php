@extends('frontend.layouts.master')

@push('css')
@endpush

@php
    //get selected language
    $lang = selectedLang();
    // contact section
    $contact_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::CONTACT_SECTION);
    $contact = App\Models\Admin\SiteSections::getData($contact_slug)->first();

@endphp

@section('content')
    <section class="contact ptb-60">
        <div class="container mx-auto">
            <div class="text-content text-center">
                <h5 class="sub-top text-center"><i class="las la-paw"></i>{{ @$contact->value->language->$lang->sub_heading }}
                </h5>
                <h2>{{ @$contact->value->language->$lang->heading }}</h2>
            </div>
            <div class="row ptb-60 mb-20-none">
                <div class="col-lg-6 mb-20">
                    <div class="thumb-right ">
                        <img src="{{ get_image(@$contact->value->image, 'site-section') }}" alt="image">
                    </div>
                </div>
                <div class="col-lg-6 mb-20">
                    <div class="row justify-content-center">
                        <div class="col-xl-12">
                            <div class="">
                                <form class="contact-form" method="POST" action="{{ route('message') }}">
                                    @csrf
                                    <div class="row justify-content-center mb-10-none">
                                        <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                                            <label>{{ __('Enter Name') }} <span>*</span></label>
                                            <input type="text" name="name" class="form--control"
                                                placeholder="Enter name">
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                                            <label>{{ __('Enter Email') }} <span>*</span></label>
                                            <input type="email" name="email" class="form--control"
                                                placeholder="Enter email">
                                        </div>
                                        <div class="col-12 form-group">
                                            <label>{{ __('Enter Subject') }} <span>*</span></label>
                                            <input type="text" name="subject" class="form--control"
                                                placeholder="Subject">
                                        </div>
                                        <div class="col-lg-12 form-group">
                                            <label>{{ __('Massage') }} <span>*</span></label>
                                            <textarea class="form--control text-area" name="message" placeholder="Write Massage" rows="3"></textarea>
                                        </div>
                                        <div class="col-lg-12 form-group text-center">
                                            <button type="submit"
                                                class="btn--base mt-30 w-100">{{ __('Send Message') }}</button>
                                        </div>
                                    </div>
                                </form>
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
