@extends('nanny.layouts.master')
@section('breadcrumb')
    @include('user.components.breadcrumb', [
        'breadcrumbs' => [
            [
                'name' => __('Dashboard'),
                'url' => setRoute('nanny.dashboard'),
            ],
        ],
        'active' => __('Dashboard'),
    ])
@endsection
@section('content')
    <div class="body-wrapper ">

        @include('user.components.welcome')

        <div class="dashboard-item-area">
            <div class="row mb-20-none">
                <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-20">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <span class="sub-title">{{ __('Balance') }}</span>
                            <h3 class="title">{{ get_amount($nanny_wallet->balance, get_default_currency_code(), 4) }}</h3>
                        </div>
                        <div class="country-card-img">
                            <img src="{{ get_image($base_currency->flag, 'currency-flag') }}" alt="flag">
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-20">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <span class="sub-title">{{ __('Total Earning') }}</span>
                            <h3 class="title">{{ $user_request->where('status', 6)->pluck('total')->sum() }}
                                {{ get_default_currency_code() }}</h3>
                        </div>
                        <div class="dashboard-icon">
                            <i class="las la-dollar-sign"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-20">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <span class="sub-title">{{ __('Total Service') }}</span>
                            <h3 class="title">{{ $user_request->whereIn('status', [1, 4, 5, 6])->count() }}</h3>
                        </div>
                        <div class="dashboard-icon">
                            <i class="las la-baby-carriage"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-20">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <span class="sub-title">{{ __('Task Complete') }}</span>
                            <h3 class="title">{{ $user_request->whereIn('status', [4, 5, 6])->count() }}</h3>
                        </div>
                        <div class="dashboard-icon">
                            <i class="las la-clipboard-check"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-20">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <span class="sub-title">{{ __('Incomplete') }}</span>
                            <h3 class="title">{{ $user_request->where('status', 2)->count() }}</h3>
                        </div>
                        <div class="dashboard-icon">
                            <i class="las la-times-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="request-history pt-60">
            <div class="log-title">
                <h3 class="title">{{ __('Service History Log') }}</h3>
            </div>
            <div class="row justify-content-center pt-3">
                <div class="col-xl-12">
                    <div class="table-area">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>{{ __('Request ID') }}</th>
                                    <th>{{ __('User Name') }}</th>
                                    <th>{{ __('Service Type') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Schedule Date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($user_request as $item)
                                    <tr>
                                        <td data-label="Request ID">{{ $item->trx }}
                                        </td>
                                        <td data-label="User Name">{{ $item->user->fullname }}
                                        </td>
                                        <td data-label="Service Type">
                                            {{ $item->service_type == 1 ? __('Baby Sitter') : __('Pet Sitter') }}
                                        </td>
                                        <td data-label="Amount">{{ get_amount($item->total,$item->currency_code,2) }}
                                        </td>
                                        <td data-label="Status">
                                            @if (@$item->status == 0)
                                                <span class="badge badge--warning">{{ __('Pending') }}</span>
                                            @elseif (@$item->status == 1)
                                                <span class="badge badge--success">{{ __('Accepted') }}</span>
                                            @elseif (@$item->status == 4)
                                                <span class="badge badge--success">{{ __('Task completed') }}</span>
                                            @elseif (@$item->status == 5)
                                                <span class="badge badge--success">{{ __('Payment') }}</span>
                                            @elseif (@$item->status == 6)
                                                <span class="badge badge--success">{{ __('Payment completed') }}</span>
                                            @endif
                                        </td>
                                        <td data-label="Email">{{ @$item->user->email }}
                                        </td>
                                        @php
                                            $started_time = $item->started_time;
                                            $started_time = \Carbon\Carbon::parse($started_time);
                                        @endphp
                                        <td data-label="Schedule Date">{{ $item->started_date }}
                                            / {{ $started_time->format('h:i:s A') }}</td>

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

                    <div class="pagination pb-5">
                        {{ $user_request->links() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
