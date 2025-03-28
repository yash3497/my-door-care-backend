@extends('admin.layouts.master')

@push('css')
@endpush

@section('page-title')
    @include('admin.components.page-title', ['title' => __($page_title)])
@endsection

@section('breadcrumb')
    @include('admin.components.breadcrumb', [
        'breadcrumbs' => [
            [
                'name' => __('Dashboard'),
                'url' => setRoute('admin.dashboard'),
            ],
        ],
        'active' => __('Dashboard'),
    ])
@endsection

@section('content')
    <div class="dashboard-area">
        <div class="dashboard-item-area">
            <div class="row">
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __('Total Transaction') }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">
                                        {{ $default_currency->symbol }}{{ get_amount($total_transaction) }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--info">{{ __('Success') }}:
                                        {{ $default_currency->symbol }}{{ get_amount($success_transaction) }}</span>
                                    <span class="badge badge--warning">{{ __('Pending') }}:
                                        {{ $default_currency->symbol }}{{ get_amount($panding_transaction) }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart9" data-percent="{{ get_amount($percent_transaction) }}">
                                    <span>{{ get_amount($percent_transaction) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __('User Active Tickets') }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ get_amount($total_tickets) }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--warning">{{ __('Pending') }}
                                        {{ get_amount($pending_tickets) }}</span>
                                    <span class="badge badge--success">{{ __('Solved') }}
                                        {{ get_amount($active_tickets) }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart10" data-percent="{{ get_amount($ticket_perchant) }}">
                                    <span>{{ get_amount($ticket_perchant) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __('Total Users') }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ get_amount($total_users) }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--info">{{ __('Active') }}
                                        {{ get_amount($active_users) }}</span>
                                    <span class="badge badge--warning">{{ __('Unverified') }}
                                        {{ get_amount($unverified_users) }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart11" data-percent="{{ get_amount($user_perchant) }}">
                                    <span>{{ get_amount($user_perchant) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __('Total Nannies') }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ get_amount($total_nannies) }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--info">{{ __('Active') }}
                                        {{ get_amount($active_nannies) }}</span>
                                    <span class="badge badge--warning">{{ __('Unverified') }}
                                        {{ get_amount($unverified_nannies) }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart6" data-percent="{{ get_amount($nanny_perchant) }}">
                                    <span>{{ get_amount($nanny_perchant) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="chart-area mt-15">
        <div class="row mb-15-none">

            <div class="col-xxxl-6 col-xxl-3 col-xl-6 col-lg-6 mb-15">
                <div class="chart-wrapper">
                    <div class="chart-area-header">
                        <h5 class="title">{{ __('User Analytics') }}</h5>
                    </div>
                    <div class="chart-container">
                        <div id="chart4" data-chart_four="{{ json_encode($chart_four) }}" class="balance-chart">
                        </div>

                    </div>
                    <div class="chart-area-footer">
                        <div class="chart-btn">
                            <a href="{{ setRoute('admin.users.index') }}"
                                class="btn--base w-100">{{ __('View Users') }}</a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxxl-6 col-xxl-3 col-xl-6 col-lg-6 mb-15">
                <div class="chart-wrapper">
                    <div class="chart-area-header">
                        <h5 class="title">{{ __('Nanny Analytics') }}</h5>
                    </div>
                    <div class="chart-container">
                        <div id="chart5" data-chart_five="{{ json_encode($chart_five) }}" class="balance-chart">
                        </div>

                    </div>
                    <div class="chart-area-footer">
                        <div class="chart-btn">
                            <a href="{{ route('admin.nannies.index') }}"
                                class="btn--base w-100">{{ __('View Nannies') }}</a>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('script')
@endpush
