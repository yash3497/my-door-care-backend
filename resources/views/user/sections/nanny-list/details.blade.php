@extends('user.layouts.master')

@push('css')
    <style>
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #fff;
        }
    </style>
@endpush


@section('content')
    <div class="body-wrapper ">

        <div class="nanny-profile pb-120">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-10 col-md-8 col-sm-12">
                    <div class="nanny-profile-wrapper">
                        <div class="nanny-profile-img">
                            <img src="{{ @$nanny->user_image }}">
                        </div>
                        <div class="nanny-title text-center pt-3">
                            <h3 class="title">{{ @$nanny->fullname }}</h3>
                            <p>{{ @$nanny->email }}</p>
                        </div>
                        <div class="profile-button ptb-20">
                            <a href="{{ route('user.nanny.list.service.request', $nanny->id) }}"
                                class="btn--base btn">{{ __('Service Request') }}</a>
                        </div>
                        <div class="nanny-exprience ptb-20">
                            <div class="nanny-exprience-header">
                                <i class="las la-suitcase-rolling"></i>
                            </div>
                            <div class="expricence-area d-flex justify-content-around">
                                <div class="service">
                                    <h3 class="title">{{ @$total_nanny_service }}</h3>
                                    <p>{{ __('Total Service') }}</p>
                                </div>
                                <div class="service">
                                    <h3 class="title">{{ @$total_nanny_task_complate }}</h3>
                                    <p>{{ __('Task Complete') }}</p>
                                </div>
                                <div class="service">
                                    <h3 class="title">{{ @$nanny->userRequests->where('status', 3)->count() }}</h3>
                                    <p>{{ __('Incomplete') }}</p>
                                </div>
                            </div>
                            <div class="exprience-charge-area d-flex justify-content-evenly pb-2">
                                <div class="charge d-flex align-items-center">
                                    <div class="left">
                                        <i class="las la-briefcase"></i>
                                    </div>
                                    <div class="right text-center">
                                        <h4 class="title">{{ @$nanny->nannyProfession->work_experience }}</h4>
                                        <p>{{ __('Exprience') }}</p>
                                    </div>
                                </div>
                                <div class="charge d-flex align-items-center">
                                    <div class="left">
                                        <i class="las la-wallet"></i>
                                    </div>
                                    <div class="right text-center">
                                        <h4 class="title">
                                            {{ get_amount(@$nanny->nannyProfession->amount, null, 4) }}
                                            {{ get_default_currency_code() }}/{{ @$nanny->nannyProfession->chargeType }}
                                        </h4>
                                        <p>{{ __('Charge') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="nanny-address d-flex align-items-center justify-content-center">
                                <div class="left">
                                    <i class="las la-street-view"></i>
                                </div>
                                <div class="right">
                                    <p>{{ @$nanny->fullAddress }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="customer-review pt-5">
                            <div class="testimonial-section">
                                <div class="testimonial-slider swiper-container-horizontal">
                                    <div class="swiper-wrapper"
                                        style="transform: translate3d(-1084px, 0px, 0px); transition-duration: 0ms;">

                                        @forelse ($reviews as $review)
                                            <div class="swiper-slide swiper-slide-prev" data-swiper-slide-index="0"
                                                style="width: 512px; margin-right: 30px;">
                                                <div class="testimonial-wrapper">
                                                    <div class="testimonial-ratings">
                                                        @for ($number = 1; $number <= $review->rating; $number++)
                                                            <i class="fas fa-star"></i>
                                                        @endfor

                                                    </div>
                                                    <p class="d-block">{{ $review->comment }}</p>
                                                    <div class="client-details d-flex justify-content-between">
                                                        <div class="client-img">
                                                            {{-- <img src="{{ get_image($review->user->image, 'user-profile') }}"
                                                                alt="client"> --}}
                                                            <img src="{{ @$nanny->user_image }}">
                                                        </div>
                                                        <div class="client-title">
                                                            <h4 class="title ">{{ $review->user->fullname }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                        @endforelse

                                    </div>
                                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                                </div>
                                <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets"><span
                                        class="swiper-pagination-bullet" tabindex="0" role="button"
                                        aria-label="Go to slide 1"></span><span
                                        class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0"
                                        role="button" aria-label="Go to slide 2"></span><span
                                        class="swiper-pagination-bullet" tabindex="0" role="button"
                                        aria-label="Go to slide 3"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
