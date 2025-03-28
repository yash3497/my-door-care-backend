@extends('frontend.layouts.master')
@php
    //get selected language
    $lang = selectedLang();
@endphp

@push('css')
@endpush

@section('content')
    <section class="blog-details ptb-80">
        <div class="container mx-auto">
            <div class="row">
                <div class="col-lg-8">
                    <div class="right-content">
                        <img src="{{ get_image(@$blog->image, 'blog') }}" alt="image">
                        <h3>{{ @$blog->title->language->$lang->title }}</h3>
                        <div class="details">
                            <p>{!! @$blog->description->language->$lang->description !!}</p>
                        </div>
                        <div class="hr"></div>

                        <div class="tag">
                            @if ($blog->tags)
                                @foreach ($blog->tags as $tag)
                                    <a href="">{{ $tag }}</a>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-lg-4 left-content pt-lg-0 pt-md-0 pt-3">
                    <h3>{{ __('Recent Posts') }}</h3>
                    <div class="hr"></div>
                    <div>
                        @forelse ($recentPost as $item)
                            <div class="d-flex mb-4">
                                <div class="me-3 blog-catagori-img">
                                    <a href="{{ route('blog.details', [$item->id, $item->slug]) }}">
                                        <img src="{{ get_image($item->image, 'blog') }}" alt="image">
                                    </a>
                                </div>
                                <div>
                                    <p>{{ @$item->created_at->format('dS M, Y') }}</p>
                                    <h4>
                                        <a href="{{ route('blog.details', [$item->id, $item->slug]) }}">{{ @$item->title->language->$lang->title }}
                                        </a>
                                    </h4>
                                </div>
                            </div>
                        @empty
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="baybs-data">
                                        <p>{{ __('Data Not Found !') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforelse


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('script')
@endpush
