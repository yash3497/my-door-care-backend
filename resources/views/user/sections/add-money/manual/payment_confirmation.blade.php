@extends('user.layouts.master')

@push('css')
    <style>
        .jp-card .jp-card-back,
        .jp-card .jp-card-front {

            background-image: linear-gradient(160deg, #2583C5 0%, #813FD6 100%) !important;
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
        'active' => __('Manual Payment'),
    ])
@endsection

@section('content')
    <div class="body-wrapper ">
        <div class="table-content">
            @include('user.components.welcome')
        </div>

        <div class="dashboard-item-area">
            <div class="dashboard-header-wrapper">
                <h3 class="title">{{ __(@$page_title) }}</h3>
            </div>
        </div>
        <div class="row mb-30-none justify-content-center">
            <div class="col-lg-6 mb-30">
                <div class="dash-payment-item-wrapper">
                    <div class="dash-payment-item active">
                        <div class="dash-payment-title-area">
                            <span class="dash-payment-badge">!</span>
                            <h5 class="title">
                                @php
                                    echo @$gateway->desc;
                                @endphp
                            </h5>
                        </div>
                        <div class="dash-payment-body">
                            <form class="card-form" action="{{ setRoute('user.add.money.manual.payment.confirmed') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    @foreach ($gateway->input_fields as $item)
                                        @if ($item->type == 'select')
                                            <div class="col-lg-12 form-group">
                                                <label for="{{ $item->name }}">{{ $item->label }}</label>
                                                <select name="{{ $item->name }}" id="{{ $item->name }}"
                                                    class="form--control nice-select">
                                                    <option selected disabled>Choose One</option>
                                                    @foreach ($item->validation->options as $innerItem)
                                                        <option value="{{ $innerItem }}">{{ $innerItem }}</option>
                                                    @endforeach
                                                </select>
                                                @error($item->name)
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        @elseif ($item->type == 'file')
                                            <div class="col-lg-12 form-group">
                                                @include('admin.components.form.input-dynamic', [
                                                    'label' => $item->label,
                                                    'name' => $item->name,
                                                    'type' => $item->type,
                                                
                                                    'value' => old($item->name),
                                                    'required' => 'required',
                                                ])
                                            </div>
                                        @elseif ($item->type == 'text')
                                            <div class="col-lg-12 form-group">
                                                @include('admin.components.form.input-dynamic', [
                                                    'label' => $item->label,
                                                    'name' => $item->name,
                                                    'type' => $item->type,
                                                    'value' => old($item->name),
                                                    'required' => 'required',
                                                ])
                                            </div>
                                        @elseif ($item->type == 'textarea')
                                            <div class="col-lg-12 form-group">
                                                @include('admin.components.form.textarea', [
                                                    'label' => $item->label,
                                                    'name' => $item->name,
                                                    'value' => old($item->name),
                                                ])
                                            </div>
                                        @endif
                                    @endforeach
                                    <div class="col-xl-12 col-lg-12">
                                        <button type="submit" class="btn--base w-100 btn-loading">
                                            {{ __('Confirm Payment') }}

                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-30">
                <div class="dash-payment-item-wrapper">
                    <div class="dash-payment-item active">
                        <div class="dash-payment-title-area">
                            <span class="dash-payment-badge">!</span>
                            <h5 class="title">{{ _('Payment Information') }}</h5>
                        </div>
                        <div class="dash-payment-body">
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
                                            class="request-amount">{{ number_format(@$hasData->data->amount->requested_amount, 2) }}
                                            {{ @$hasData->data->amount->default_currency }}</span>
                                    </div>
                                </div>
                                <div class="preview-list-item">
                                    <div class="preview-list-left">
                                        <div class="preview-list-user-wrapper">
                                            <div class="preview-list-user-icon">
                                                <i class="las la-exchange-alt"></i>
                                            </div>
                                            <div class="preview-list-user-content">
                                                <span>{{ __('Exchange Rate') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="preview-list-right">
                                        <span class="request-amount">{{ __('1') }} {{ get_default_currency_code() }}
                                            =
                                            {{ number_format(@$hasData->data->amount->sender_cur_rate, 2) }}
                                            {{ @$hasData->data->amount->sender_cur_code }}</span>
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
                                        <span class="fees">{{ number_format(@$hasData->data->amount->total_charge, 2) }}
                                            {{ @$hasData->data->amount->sender_cur_code }}</span>
                                    </div>
                                </div>
                                <div class="preview-list-item">
                                    <div class="preview-list-left">
                                        <div class="preview-list-user-wrapper">
                                            <div class="preview-list-user-icon">
                                                <i class="lab la-get-pocket"></i>
                                            </div>
                                            <div class="preview-list-user-content">
                                                <span>{{ __('Will Get') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="preview-list-right">
                                        <span
                                            class="will-get">{{ number_format(@$hasData->data->amount->requested_amount, 2) }}
                                            {{ @$hasData->data->amount->default_currency }}</span>
                                    </div>
                                </div>
                                <div class="preview-list-item">
                                    <div class="preview-list-left">
                                        <div class="preview-list-user-wrapper">
                                            <div class="preview-list-user-icon">
                                                <i class="las la-money-check-alt"></i>
                                            </div>
                                            <div class="preview-list-user-content">
                                                <span class="last">{{ __('Total Payable Amount') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="preview-list-right">
                                        <span
                                            class="text--warning last pay-in-total">{{ number_format(@$hasData->data->amount->total_amount, 2) }}
                                            {{ @$hasData->data->amount->sender_cur_code }}</span>
                                    </div>
                                </div>
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
