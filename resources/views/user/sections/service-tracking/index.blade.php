@extends('user.layouts.master')

@push('css')
    <style>
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #fff;
        }

        .lass-p {
            margin-bottom: 0px;
        }
    </style>
@endpush

@section('breadcrumb')
    @include('user.components.breadcrumb', [
        'breadcrumbs' => [
            [
                'name' => __('Dashboard'),
                'url' => setRoute('user.dashboard'),
            ],
        ],
        'active' => __('Service Tracking'),
    ])
@endsection

@section('content')
    <div class="body-wrapper ">
        <div class="dashboard-list-area mt-20 pb-120">
            <div class="dashboard-header-wrapper">
                <h3 class="title">{{ __('Service Tracking') }}</h3>
            </div>
            <div class="dashboard-list-wrapper mt-5">

                @forelse ($user_requests as $key =>  $user_request)
                    @php
                        $rand_value = $key + 1 + $user_request->id;
                    @endphp
                    <div class="dashboard-list-item-wrapper">
                        <div class="dashboard-list-item sent">
                            <div class="dashboard-list-left">
                                <div class="dashboard-list-user-wrapper">
                                    <div class="dashboard-list-user-icon">
                                        <i class="las la-arrow-up"></i>
                                    </div>
                                    <div class="dashboard-list-user-content">
                                        <h4 class="title">{{ @$user_request->nanny->fullname }}</h4>
                                        @if (@$user_request->status == 0)
                                            <span class="badge badge--warning">{{ __('Pending') }}</span>
                                        @elseif (@$user_request->status == 1)
                                            <span class="badge badge--success">{{ __('Accepted') }}</span>
                                        @elseif (@$user_request->status == 4)
                                            <span class="badge badge--success">{{ __('Task completed') }}</span>
                                        @elseif (@$user_request->status == 5)
                                            <span class="badge badge--success">{{ __('Payment') }}</span>
                                        @elseif (@$user_request->status == 6)
                                            <span class="badge badge--success">{{ __('Performance Review') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="dashboard-list-right">
                                <h4 class="main-money text--base">{{ @$user_request->created_at->format('d-m-Y') }}</h4>
                                <h6 class="exchange-money">
                                    {{ @$user_request->nanny_charge }}{{ $default_currency->symbol }}/hr</h6>
                            </div>
                        </div>
                        <div class="preview-list-wrapper" style="display: none;">
                            <div class="preview-list-item">
                                <div class="preview-list-left">
                                    <div class="preview-list-user-wrapper">
                                        <div class="preview-list-user-icon">
                                            <i class="las la-user"></i>
                                        </div>
                                        <div class="preview-list-user-content">
                                            <span>{{ __('Name') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-list-right">
                                    <span>{{ @$user_request->nanny->fullname }}</span>
                                </div>
                            </div>
                            <div class="preview-list-item">
                                <div class="preview-list-left">
                                    <div class="preview-list-user-wrapper">
                                        <div class="preview-list-user-icon">
                                            <i class="las la-envelope"></i>
                                        </div>
                                        <div class="preview-list-user-content">
                                            <span>{{ __('Email') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-list-right">
                                    <span>{{ @$user_request->nanny->email }}</span>
                                </div>
                            </div>

                            <div class="preview-list-item">
                                <div class="preview-list-left">
                                    <div class="preview-list-user-wrapper">
                                        <div class="preview-list-user-icon">
                                            <i class="las la-map-marker"></i>
                                        </div>
                                        <div class="preview-list-user-content">
                                            <span>{{ __('Request ID') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-list-right">
                                    <span>{{ @$user_request->trx }}</span>
                                </div>
                            </div>
                            <div class="preview-list-item">
                                <div class="preview-list-left">
                                    <div class="preview-list-user-wrapper">
                                        <div class="preview-list-user-icon">
                                            <i class="las la-map-marker"></i>
                                        </div>
                                        <div class="preview-list-user-content">
                                            <span>{{ __('Address') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-list-right">
                                    <span>{{ @$user_request->nanny->full_address }}</span>
                                </div>
                            </div>

                            <div class="preview-list-item">
                                <div class="preview-list-left">
                                    <div class="preview-list-user-wrapper">
                                        <div class="preview-list-user-icon">
                                            <i class="las la-phone"></i>
                                        </div>
                                        <div class="preview-list-user-content">
                                            <span>{{ __('Phone') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-list-right">
                                    <span>{{ @$user_request->nanny->mobile }}</span>
                                </div>
                            </div>

                            <div class="preview-list-item">
                                <div class="preview-list-left">
                                    <div class="preview-list-user-wrapper">
                                        <div class="preview-list-user-icon">
                                            <i class="las la-hand-holding-heart"></i>
                                        </div>
                                        <div class="preview-list-user-content">
                                            <span>{{ __('Service Type') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-list-right">
                                    <span class="text--danger">1
                                        {{ @$user_request->service_type == 1 ? __('Baby') : __('Pet') }}</span>
                                </div>
                            </div>
                            <div class="preview-list-item">
                                <div class="preview-list-left">
                                    <div class="preview-list-user-wrapper">
                                        <div class="preview-list-user-icon">
                                            <i class="las la-calendar-day"></i>
                                        </div>
                                        <div class="preview-list-user-content">
                                            <span>{{ __('Service Day') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-list-right">

                                    <span>{{ @$user_request->service_day }}
                                        {{ @$user_request->service_day == 1 ? __('Day') : __('Days') }}</span>
                                </div>
                            </div>
                            <div class="preview-list-item">
                                <div class="preview-list-left">
                                    <div class="preview-list-user-wrapper">
                                        <div class="preview-list-user-icon">
                                            <i class="las la-calendar-week"></i>
                                        </div>
                                        <div class="preview-list-user-content">
                                            <span>{{ __('Service Date') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-list-right">
                                    <span>{{ date('d-m-Y', strtotime($user_request->started_date)) }}</span>
                                </div>
                            </div>
                            <div class="preview-list-item">
                                <div class="preview-list-left">
                                    <div class="preview-list-user-wrapper">
                                        <div class="preview-list-user-icon">
                                            <i class="las la-clock"></i>
                                        </div>
                                        <div class="preview-list-user-content">
                                            <span>{{ __('Service Time') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-list-right">
                                    @php
                                        $start_time = $user_request->started_time;
                                        $carbon_start_time = Carbon\Carbon::parse($start_time);

                                        $daily_working_hour = $user_request->daily_working_hour;
                                        $work_start_time = $user_request->started_time;
                                        $carbonTime = Carbon\Carbon::parse($work_start_time);
                                        $newTime = $carbonTime->addHours($daily_working_hour);

                                    @endphp

                                    <span> {{ $carbon_start_time->format('h:i:s A') }} -
                                        {{ $newTime->format('h:i:s A') }}
                                    </span>
                                </div>
                            </div>
                            <div class="preview-list-item">
                                <div class="preview-list-left">
                                    <div class="preview-list-user-wrapper">
                                        <div class="preview-list-user-icon">
                                            <i class="las la-wallet"></i>
                                        </div>
                                        <div class="preview-list-user-content">
                                            <span>{{ __("Nanny's Bill") }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-list-right">
                                    <span>{{ @$user_request->total }} {{ @$user_request->currency_code }}
                                    </span>
                                </div>
                            </div>
                            <div class="preview-list-item">
                                <div class="preview-list-left">
                                    <div class="preview-list-user-wrapper">
                                        <div class="preview-list-user-icon">
                                            <i class="las la-battery-half"></i>
                                        </div>
                                        <div class="preview-list-user-content">
                                            <span>{{ __('Service Charge') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-list-right">
                                    <span>{{ get_amount(@$user_request->service_charge) }}
                                        {{ @$user_request->currency_code }}
                                    </span>
                                </div>
                            </div>
                            <div class="preview-list-item">
                                <div class="preview-list-left">
                                    <div class="preview-list-user-wrapper">
                                        <div class="preview-list-user-icon">
                                            <i class="las la-battery-full"></i>
                                        </div>
                                        <div class="preview-list-user-content">
                                            <span>{{ __('Total') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-list-right">
                                    <span>{{ get_amount(@$user_request->payable) }} {{ @$user_request->currency_code }}
                                    </span>
                                </div>
                            </div>

                            <div class="tracking-area text-center">
                                <h3 class="title">{{ __('Tracking') }}</h3>
                                <div
                                    class="process-wrap @if ($user_request->status == 0) active-step1
                                @elseif ($user_request->status == 1)
                                active-step2
                                @elseif ($user_request->status == 4)
                                active-step3
                                @elseif ($user_request->status == 5)
                                active-step4
                                @elseif ($user_request->status == 6)
                                active-step4 @endif ">
                                    @php
                                        $user_input = $user_request->status;
                                        $status = [0, 1, 4, 5, 6];
                                    @endphp
                                    <div class="process-main">
                                        <div class="col-3 ">
                                            <div class="process-step-cont pb-20">
                                                <div
                                                    class="process-step step-1 {{ $user_request->status == 0 ? 'passed' : '' }}">
                                                </div>
                                                <span class="process-label">{{ __('Pending') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-3 ">
                                            <div class="process-step-cont">
                                                <div
                                                    class="process-step step-2 {{ $user_request->status == 1 ? 'passed' : '' }}">
                                                </div>
                                                <span class="process-label">{{ __('Accepted') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="process-step-cont">
                                                <div
                                                    class="process-step step-3 {{ $user_request->status == 4 ? 'passed' : '' }}">
                                                </div>
                                                <span class="process-label">{{ __('Task Completed') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="process-step-cont">
                                                @if ($user_request->status == 5)
                                                    <div
                                                        class="process-step step-4 {{ $user_request->status == 5 ? 'passed' : '' }}">
                                                    </div>
                                                @elseif ($user_request->status == 6)
                                                    <div
                                                        class="process-step step-4 {{ $user_request->status == 6 ? 'passed' : '' }}">
                                                    </div>
                                                @else
                                                    <div class="process-step step-4">
                                                    </div>
                                                @endif

                                                <span class="process-label">{{ __('Payment') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="review-btn">
                                    @if ($user_request->status == 0)
                                        <div class="service-review-button pt-3">
                                            <a href="{{ route('user.service.tracking.cancel', $user_request->id) }}"
                                                class="btn--base cancel-request-btn w-50">{{ __('Cancel Service') }}</a>
                                        </div>
                                    @endif
                                    @if ($user_request->status == 4)
                                        <div class="service-review-button pb-20">

                                            <form class="card-form" action="{{ setRoute('user.add.money.submit') }}"
                                                method="POST">
                                                @csrf

                                                <div class="payment-type pt-4">
                                                    <div class="form-group">
                                                        <h5 class="title">{{ __('Select Payment Method') }}</h5>
                                                        <div class="radio-wrapper pt-4">
                                                            @php
                                                                $counter = 0;

                                                            @endphp
                                                            @forelse ($payment_gateways_currencies as $key=>$payment_gateways_currency)
                                                                <input type="hidden" class="form--control"
                                                                    name="amount" value="{{ $user_request->payable }}">
                                                                <input type="hidden" class="form--control"
                                                                    name="user_request_id"
                                                                    value="{{ $user_request->id }}">

                                                                <div class="radio-item">
                                                                    <input type="radio"
                                                                        id="level-{{ $key + $user_request->id }}-{{ $payment_gateways_currency->alias }}"
                                                                        class="hide-input"
                                                                        {{ $counter == 0 ? 'checked' : '' }}
                                                                        name="currency"
                                                                        value="{{ $payment_gateways_currency->alias }}">
                                                                    <label
                                                                        for="level-{{ $key + $user_request->id }}-{{ $payment_gateways_currency->alias }}">
                                                                        <img src="{{ get_image($payment_gateways_currency->gateway->image, 'payment-gateways') }}"
                                                                            alt="icon">
                                                                        {{ $payment_gateways_currency->name }}</label>
                                                                </div>
                                                                @php
                                                                    $counter++;
                                                                @endphp
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

                                                <button type="submit"
                                                    class="btn--base w-100">{{ __('Payment') }}</button>
                                            </form>


                                        </div>
                                    @endif
                                    @if ($user_request->status == 5)
                                        <div class="service-review-button">
                                            <a href="#" class="btn--base w-50 review_btn"
                                                data-id="{{ $user_request->id }}">{{ __('Performance Review') }}</a>
                                        </div>
                                    @endif
                                    @if ($user_request->status == 6)
                                        @php
                                            $review = App\Models\Review::where('user_request_id', $user_request->id)
                                                ->where('nanny_id', $user_request->nanny_id)
                                                ->where('user_id', $user_request->user_id)
                                                ->first();
                                        @endphp
                                        @if ($review)
                                            <h4>{{ __('Your Review') }}</h4>
                                            <p class="lass-p">{{ $review->comment }}</p>
                                            @for ($number = 1; $number <= $review->rating; $number++)
                                                <i class="las la-star"></i>
                                            @endfor
                                        @endif
                                    @endif


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

    <!-- modal -->
    <div class="modal fade" id="review_modal" tabindex="-1" aria-labelledby="Review" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header" id="Review">
                    <h4 class="modal-title">{{ __('Review') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ptb-20">
                    <div class="create-offer">
                        <div class="review-header text-center pb-3">
                            <h3 class="title">{{ __('Rate Nanny') }}</h3>
                            <p>{{ __('Tap a star to set your rating. Add more description here if you want.') }}</p>
                        </div>
                        <div class="ratting-star text-center">
                            <form class="ratings-form" method="POST" action="{{ route('user.user_request.rating') }}">
                                @csrf
                                <input type="hidden" name="review_id">
                                <div class="form-group rating">
                                    <input type="radio" id="star1" name="rating" value="5" /><label
                                        for="star1">&nbsp;</label>
                                    <input type="radio" id="star2" name="rating" value="4" /><label
                                        for="star2">&nbsp;</label>
                                    <input type="radio" id="star3" name="rating" value="3" /><label
                                        for="star3">&nbsp;</label>
                                    <input type="radio" id="star4" name="rating" value="2" /><label
                                        for="star4">&nbsp;</label>
                                    <input type="radio" id="star5" name="rating" value="1" /><label
                                        for="star5">&nbsp;</label>
                                </div>


                        </div>
                        <div class="comment-area pt-3">
                            <input type="text" name="comment" class="form--control"
                                placeholder="Write here about service experience">
                        </div>
                        <div class="modal-btn pt-4">
                            <button type="submit" class="btn--base btn w-100">{{ __('Review') }}</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        /**This is just a demo to add the process classes**/
        $(document).ready(function($) {
            $(".process-step").click(function() {
                var theClass = $(this).attr("class").match(/(^|\s)step-\S+/g);
                var bute = $.trim(theClass);
                switch (bute) {
                    case "step-1":
                        $(".process-wrap").addClass("active-step1")
                        break;
                    case 'step-2':
                        $(".process-wrap").attr('class', 'process-wrap');
                        $(this).parents(".process-wrap").addClass("active-step2")
                        break;
                    case 'step-3':
                        $(".process-wrap").attr('class', 'process-wrap');
                        $(this).parents(".process-wrap").addClass("active-step3")
                        break;
                    case 'step-4':
                        $(".process-wrap").attr('class', 'process-wrap');
                        $(this).parents(".process-wrap").addClass("active-step4")
                        break;

                    default:
                        $(".process-wrap").attr('class', 'process-wrap');
                }
            })

            $(".process-dots").click(function() {
                if ($(this).hasClass("ship-process-dot-1")) {
                    $(".process-wrap").attr('class', 'process-wrap active-step1')
                    $(this).parents().find(".process-wrap").addClass("active-step1")

                }
                if ($(this).hasClass("ship-process-dot-2")) {
                    $(".process-wrap").attr('class', 'process-wrap active-step1')
                    $(this).parents().find(".process-wrap").addClass("active-step1-mini2")

                }
                if ($(this).hasClass("ship-process-dot-3")) {
                    $(".process-wrap").attr('class', 'process-wrap active-step1')
                    $(this).parents().find(".process-wrap").addClass("active-step1-mini3")

                }
                if ($(this).hasClass("ship-process-dot-4")) {
                    $(".process-wrap").attr('class', 'process-wrap active-step1')
                    $(this).parents().find(".process-wrap").addClass("active-step1-mini4")
                }
            });

            $('.review_btn').click(function() {
                let id = $(this).data('id');
                $('#review_modal input[name=review_id]').val(id);
                $('#review_modal').modal('show');
            })

        });
    </script>
@endpush
