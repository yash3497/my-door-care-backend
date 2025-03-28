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
        <div class="nany-wrapper pb-120">
            <!-- nanny-filtaring -->
            <div class="nannylist-header d-flex justify-content-between pb-60">
                <div class="left">
                    <h3 class="title">{{ __('Choice Nanny To Get Service') }}</h3>
                </div>
                <div class="right">
                    <div class="sort-btn">
                        <button class="btn" data-bs-toggle="modal" data-bs-target="#sort-modal">
                            <i class="las la-filter"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse ($nannies as $nanny)
                    <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 pb-20">
                        <div class="nanny-area">
                            <div class="nanny-img">
                                <img src="{{ @$nanny->user_image }}">
                            </div>
                            <div class="nanny-content">
                                <div class="nanny-content-title d-flex justify-content-between">
                                    <div class="title">
                                        <h3 class="title">{{ @$nanny->fullname }}</h3>
                                    </div>
                                    <div class="service-type">
                                        <p>{{ @$nanny->nannyProfession->profession_type == 1 ? __('Baby Sitter') : __('Pet Sitter') }}
                                        </p>
                                    </div>
                                </div>
                                <p> {{ @$nanny->nannyProfession->bio }}</p>
                                <div class="nanny-footer d-flex justify-content-between align-items-center">
                                    @if ($nanny->review)
                                        @php
                                            $average_rating = ceil($nanny->review->pluck('rating')->sum() / 5);
                                            $complete_works = App\Models\UserRequest::where('nanny_id', $nanny->id)
                                                ->whereIn('status', [4, 5, 6])
                                                ->count();
                                        @endphp

                                        <div class="reating-area text-center">
                                            <div class="rating">{{ @$average_rating }} <span class="text--base">
                                                    ({{ @$complete_works }})
                                                </span>
                                            </div>
                                            <div class="star">

                                                @for ($number = 1; $number <= $average_rating; $number++)
                                                    <i class="fas fa-star"></i>
                                                @endfor

                                            </div>
                                            <div class="gate-order">
                                                <h6 class="title">{{ __('Total Service') }}</h6>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="nanny-price">
                                        <p>{{ @$nanny->nannyProfession->amount }}
                                            {{ get_default_currency_code() }}/{{ @$nanny->nannyProfession->chargeType }}
                                        </p>
                                    </div>
                                </div>
                                <div class="details-btn pt-30">
                                    <a href="{{ route('user.nanny.list.details', $nanny->id) }}"
                                        class="btn--base w-100">{{ __('About More') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="baybs-data">
                                <p>{{ __('Data Not Found') }}</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!--Modal-->
    <div class="modal fade" id="sort-modal" tabindex="-1" aria-labelledby="sortmodal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" id="sortmodal">
                    <h4 class="modal-title">{{ __('Filtering Nanny Service.') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ptb-10">
                    <div class="nany-filtering pb-20">
                        <form action="">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 mb-20">
                                    <div class="nanny-service-item">
                                        <label class="mb-3">{{ __('Service Area') }}</label>
                                        <div>
                                            <select class="form--control py-0 w-100" name="area">
                                                @if ($service_areas)
                                                    <option selected disabled>{{ __('Choose One') }}</option>

                                                    @foreach ($service_areas as $item)
                                                        <option value="{{ $item->slug }}">
                                                            {{ $item->service_area }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 mb-20">
                                    <div class="nanny-service-item">
                                        <label class="mb-3">{{ __('Profession Type') }}</label>
                                        <div>
                                            <select class="form--control py-0 w-100" name="profession_type">
                                                <option selected disabled>{{ __('Choose One') }}</option>
                                                <option value="1">{{ __('Baby Sitter') }}</option>
                                                <option value="2">{{ __('Pet Sitter') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-20">
                                    <div class="nanny-service-item">
                                        <label class="mb-3"> {{ __('Work Experience') }}</label>
                                        <div>
                                            <select class="form--control py-0 w-100" name="work_experience">
                                                <option selected disabled>{{ __('Choose One') }}</option>
                                                @foreach (AGE as $item)
                                                    <option value="{{ $item }}">{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-20">
                                    <div class="nanny-service-item">
                                        <label class="mb-3"> {{ __('Work Capability') }}</label>
                                        <div>
                                            <select class="form--control py-0 w-100" name="work_capability">
                                                <option selected disabled>Choose One</option>
                                                @foreach (WORK_CAPABILITY as $item)
                                                    <option value="{{ $item }}">{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-20">
                                    <div class="nanny-service-item">
                                        <label class="mb-3"> {{ __('Type of Charge') }}</label>
                                        <div>
                                            <select class="form--control py-0 w-100" name="charge">
                                                <option selected disabled>{{ __('Choose One') }}</option>
                                                @foreach (CHARGE as $item)
                                                    <option value="{{ $item }}">{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="filtraing-btn pt-3">
                                <button type="submit" class="btn--base w-100">{{ __('Apply Filter') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
