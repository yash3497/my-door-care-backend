@php
    $app_local_lang = get_default_language_code();
@endphp
@extends('frontend.layouts.master')

@push('css')
@endpush


@section('content')
    <section class="inner-banner-section pt-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="inner-banner-content">
                        <h2 class="title">{{ $useful_link->title->language->$app_local_lang->title }}</span></h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="how-we-do-section ptb-20">
        <div class="container">
            {!! $useful_link->content?->language?->$app_local_lang->content ?? '' !!}
        </div>
    </section>
@endsection


@push('script')
@endpush
