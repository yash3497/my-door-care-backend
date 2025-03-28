@extends('nanny.layouts.master')

@push('css')
    <style>
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #fff;
        }

        .unseen {
            background-color: rgba(253, 159, 22, 0.07) !important;
        }
    </style>
@endpush
@section('content')
    <div class="body-wrapper ">
        <div class="dashboard-list-area mt-20">
            <div class="dashboard-header-wrapper">
                <h2 class="title">{{ __('Service Request') }}</h2>
            </div>
            <div class="dashboard-list-wrapper mt-5">
                @forelse ($user_requests as $user_request)
                    <div class="dashboard-list-item-wrapper">
                        <div id="watch-"
                            class="dashboard-list-item {{ $user_request->seen_status == 'unseen' ? 'unseen' : '' }} sent"
                            data-id={{ $user_request->id }}>
                            <div class="dashboard-list-left">
                                <div class="dashboard-list-user-wrapper">
                                    <div class="dashboard-list-user-icon">
                                        <i class="las la-arrow-up"></i>
                                    </div>
                                    <div class="dashboard-list-user-content">
                                        <h4 class="title">{{ @$user_request->user->fullname }}</h4>

                                        @if (@$user_request->status == 0)
                                            <span class="badge badge--warning">{{ __('Pending') }}</span>
                                        @elseif (@$user_request->status == 1)
                                            <span class="badge badge--success">{{ __('Start Working') }}</span>
                                        @elseif (@$user_request->status == 2)
                                            <span class="badge badge--danger">{{ __('Rejected') }}</span>
                                        @elseif (@$user_request->status == 4)
                                            <span class="badge badge--success">{{ __('Task completed') }}</span>
                                        @elseif (@$user_request->status == 5)
                                            <span class="badge badge--success">{{ __('Payment') }}</span>
                                        @elseif (@$user_request->status == 6)
                                            <span class="badge badge--success">{{ __('Payment') }}</span>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div class="dashboard-list-right">
                                <h4 class="main-money text--base">{{ @$user_request->created_at->format('d-m-Y') }}</h4>
                                <h6 class="exchange-money">{{ @$user_request->nanny_charge }}$/hr</h6>
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
                                    <span>{{ @$user_request->user->fullname }}</span>
                                </div>
                            </div>
                            <div class="preview-list-item">
                                <div class="preview-list-left">
                                    <div class="preview-list-user-wrapper">
                                        <div class="preview-list-user-icon">
                                            <i class="las la-user"></i>
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
                                            <i class="las la-envelope"></i>
                                        </div>
                                        <div class="preview-list-user-content">
                                            <span>{{ __('Email') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-list-right">
                                    <span>{{ @$user_request->user->email }}</span>
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
                                    <span>{{ @$user_request->address }}</span>
                                </div>
                            </div>
                            @if ($user_request->user->mobile)
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
                                        <span>{{ @$user_request->user->mobile }}</span>
                                    </div>
                                </div>
                            @endif

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
                                    <span>{{ get_amount(@$user_request->total, @$user_request->currency_code, 4) }}
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
                                    <span>{{ get_amount(@$user_request->service_charge, @$user_request->currency_code, 4) }}
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
                                    <span>{{ get_amount(@$user_request->payable, @$user_request->currency_code, 4) }}
                                    </span>
                                </div>
                            </div>
                            <div class="preview-list-item">
                                <div class="preview-list-left">
                                    <div class="preview-list-user-wrapper">
                                        <div class="preview-list-user-icon">
                                            <i class="las la-smoking"></i>
                                        </div>
                                        <div class="preview-list-user-content">
                                            <span>{{ __('Status') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-list-right text-center">
                                    @if (@$user_request->status == 0)
                                        <a href="{{ route('nanny.service.request.rejected', $user_request->id) }}"
                                            class="service-btn-1">{{ __('Reject') }}</a>
                                        <a href="{{ route('nanny.service.request.approved', $user_request->id) }}"
                                            class="service-btn">{{ __('Accept') }}</a>
                                    @elseif (@$user_request->status == 1)
                                        <a
                                            href="{{ route('nanny.service.request.task.complate', $user_request->id) }}"class="service-btn">
                                            {{ __('Task complete') }}</a>
                                    @elseif (@$user_request->status == 2)
                                        <button class="service-btn-1" disabled>{{ __('Rejected') }}</button>
                                    @elseif (@$user_request->status == 4)
                                        <span>{{ __('Task completed') }}</span>
                                    @elseif (@$user_request->status == 5)
                                        <a href="javascript:void()" class="service-btn">
                                            {{ __('Payment') }}</a>
                                    @elseif (@$user_request->status == 6)
                                        <a href="javascript:void()"class="service-btn">
                                            {{ __('Payment') }}</a>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="baybs-data">
                                <p>{{ __('Data Not Found') }} !</p>
                            </div>
                        </div>
                    </div>
                @endforelse


            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $('.dashboard-list-item').on('click', function() {
            let bg_color = $(this);
            let id = $(this).data('id');
            let unseen_count = $('.sidebar .unseen_count');
            $.ajax({
                type: "GET",
                dataType: "JSON",
                url: "{{ url('nanny/service-request/watch/status') }}/" + id,
                success: function(response) {
                    bg_color.removeClass('unseen');
                    $('.sidebar .unseen_count').text(response);

                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    </script>
@endpush
