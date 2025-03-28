@extends('user.layouts.master')

@push('css')
@endpush

@section('breadcrumb')
    @include('user.components.breadcrumb', [
        'breadcrumbs' => [
            [
                'name' => __('Dashboard'),
                'url' => setRoute('user.dashboard'),
            ],
        ],
        'active' => __('Sell Coin'),
    ])
@endsection

@section('content')
    <div class="row mb-20-none">
        <div class="col-xl-7 col-lg-7 mb-20">
            <div class="custom-card mt-10">
                <div class="dashboard-header-wrapper">
                    <h4 class="title">{{ __($page_title) }}</h4>
                </div>
                <div class="card-body">
                    <div class="instructions mb-4">
                        {!! $gateway->desc !!}
                    </div>
                    <form class="card-form bounce-safe" action="{{ setRoute('user.sell.coin.instruction.submit', $token) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('user.components.payment-gateway.generate-dy-input', [
                            'input_fields' => array_reverse($gateway->input_fields),
                        ])
                        <div class="btn-wrapper">
                            <button type="submit" class="btn--base w-100">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-5 col-lg-5 mb-20">
            <div class="custom-card mt-10">
                <div class="dashboard-header-wrapper">
                    <h4 class="title">{{ __('Summary') }}</h4>
                </div>
                <div class="card-body">
                    <div class="preview-list-wrapper">
                        <div class="preview-list-item">
                            <div class="preview-list-left">
                                <div class="preview-list-user-wrapper">
                                    <div class="preview-list-user-icon">
                                        <i class="las la-receipt"></i>
                                    </div>
                                    <div class="preview-list-user-content">
                                        <span>{{ __('Entered Amount') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="preview-list-right">
                                <span
                                    class="text--success request-amount">{{ get_amount($amount->request_amount, $amount->receiver_method_code) }}</span>
                            </div>
                        </div>
                        <div class="preview-list-item">
                            <div class="preview-list-left">
                                <div class="preview-list-user-wrapper">
                                    <div class="preview-list-user-icon">
                                        <i class="las la-receipt"></i>
                                    </div>
                                    <div class="preview-list-user-content">
                                        <span>{{ __('Exchange Rate') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="preview-list-right">
                                <span
                                    class="text--success rate-show">{{ get_amount($amount->exchange_rate, $amount->sender_method_code) }}</span>
                            </div>
                        </div>
                        <div class="preview-list-item">
                            <div class="preview-list-left">
                                <div class="preview-list-user-wrapper">
                                    <div class="preview-list-user-icon">
                                        <i class="las la-battery-half"></i>
                                    </div>
                                    <div class="preview-list-user-content">
                                        <span>{{ __('Total Fees & Charges') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="preview-list-right">
                                <span
                                    class="text--danger fees">{{ get_amount($amount->rtotal_charge, $amount->receiver_method_code) }}</span>
                            </div>
                        </div>
                        <div class="preview-list-item">
                            <div class="preview-list-left">
                                <div class="preview-list-user-wrapper">
                                    <div class="preview-list-user-icon">
                                        <i class="lab la-get-pocket"></i>
                                    </div>
                                    <div class="preview-list-user-content">
                                        <span>{{ __('Total convert amount') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="preview-list-right">
                                <span
                                    class="text--warning will-get">{{ get_amount($amount->convirsion_amount, $amount->receiver_method_code) }}</span>
                            </div>
                        </div>
                        <div class="preview-list-item">
                            <div class="preview-list-left">
                                <div class="preview-list-user-wrapper">
                                    <div class="preview-list-user-icon">
                                        <i class="las la-money-check-alt"></i>
                                    </div>
                                    <div class="preview-list-user-content">
                                        <span>{{ __('Will Get') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="preview-list-right">
                                <span
                                    class="text--warning will-get">{{ get_amount($amount->will_get, $amount->sender_method_code) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
@endpush
