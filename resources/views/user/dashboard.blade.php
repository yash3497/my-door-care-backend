@extends('user.layouts.master')

@section('breadcrumb')
    @include('user.components.breadcrumb', [
        'breadcrumbs' => [
            [
                'name' => __('Dashboard'),
                'url' => setRoute('user.dashboard'),
            ],
        ],
        'active' => __('Dashboard'),
    ])
@endsection

@section('content')
    <div class="body-wrapper ">
        <div class="table-content">
            @include('user.components.welcome')
        </div>
        <div class="dashboard-item-area">
            <div class="row mb-20-none">
                <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-20">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <span class="sub-title">{{ __('Active Service') }}</span>
                            <h3 class="title">{{ @$user_service_info->where('status', 1)->count() }}</h3>
                        </div>
                        <div class="dashboard-icon">
                            <i class="las la-radiation"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-20">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <span class="sub-title">{{ __('Baby Service') }}</span>

                            <h3 class="title">{{ @$user_service_info->where('service_type', 1)->count() }}</h3>
                        </div>
                        <div class="dashboard-icon">
                            <i class="las la-baby-carriage"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-20">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <span class="sub-title">{{ __('Pet Service') }}</span>
                            <h3 class="title">{{ @$user_service_info->where('service_type', 2)->count() }}</h3>
                        </div>
                        <div class="dashboard-icon">
                            <i class="las la-paw"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-20">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <span class="sub-title">{{ __('Total Booking') }}</span>
                            <h3 class="title">
                                {{ $total_booking ?? 0 }}
                            </h3>
                        </div>
                        <div class="dashboard-icon">
                            <i class="las la-clipboard-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="request-history pt-60">
            <div class="log-title">
                <h3 class="title">{{ __('Request History Log') }}</h3>
            </div>
            <div class="row justify-content-center pt-3">
                <div class="col-xl-12">
                    <div class="table-area">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>{{ __('Request ID') }}</th>
                                    <th>{{ __('Nanny Name') }}</th>
                                    <th>{{ __('Sevice Type') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Schedule Date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($user_service_info as $item)
                                    <tr>
                                        <td data-label="{{ __('Request ID') }}">
                                            {{ $item->trx }}
                                        </td>
                                        <td data-label="{{ __('Nanny Name') }}">{{ $item->nanny->fullname }}
                                        </td>
                                        <td data-label="{{ __('Sevice Type') }}">
                                            {{ $item->service_type == 1 ? __('Baby Sitter') : __('Pet Sitter') }}
                                        </td>

                                        <td data-label="{{ __('Status') }}">

                                            @if (@$item->status == 0)
                                                <span class="badge badge--warning">{{ __('Pending') }}</span>
                                            @elseif (@$item->status == 1)
                                                <span class="badge badge--success">{{ __('Accepted') }}</span>
                                            @elseif (@$item->status == 4)
                                                <span class="badge badge--success">{{ __('Task Completed') }}</span>
                                            @elseif (@$item->status == 5)
                                                <span class="badge badge--success">{{ __('Payment') }}</span>
                                            @elseif (@$item->status == 6)
                                                <span class="badge badge--success">{{ __('Payment completed') }}</span>
                                            @endif

                                        </td>
                                        <td data-label="{{ __('Email') }}"> {{ @$item->nanny->email }}
                                        </td>
                                        @php
                                            $started_time = $item->started_time;
                                            $time = \Carbon\Carbon::parse($started_time);

                                        @endphp
                                        <td data-label="{{ __('Schedule Date') }}">{{ date('d-m-Y') }}
                                            / {{ $time->format('h:i:s A') }}</td>

                                    </tr>
                                @empty
                                    <tr class="remove-bg">
                                        <td colspan="50">
                                            <div class="alert alert-warning justify-content-center">
                                                {{ __('No data found') }}</div>
                                        </td>
                                    </tr>
                                @endforelse


                            </tbody>
                        </table>
                    </div>

                    <div class="pagination pb-120">
                        {{ $user_service_info->links() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
@endpush
