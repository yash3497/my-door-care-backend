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
        'active' => __('Sell Coin Logs'),
    ])
@endsection

@section('content')
    <div class="table-area">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title">{{ $page_title }}</h5>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>{{ __('TRX') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Receive Amount') }}</th>
                            <th>{{ __('Send Amount') }}</th>
                            <th>{{ __('Method') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Time') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions  as $key => $item)
                            <tr>
                                <td>{{ $item->trx_id }}</td>
                                <td>{{ $item->user->email ?? 'N/A' }}</td>
                                <td>{{ get_amount($item->request_amount) }}
                                </td>
                                <td>{{ get_amount($item->details->total_info->charge->will_get, $item->details->total_info->charge->sender_method_code) }}
                                </td>
                                <td><span class="text--info">{{ $item->currency->name }}</span></td>
                                <td>
                                    <span class="{{ $item->stringStatus->class }}">{{ $item->stringStatus->value }}</span>
                                </td>
                                <td>{{ dateFormat('d M y h:i:s A', $item->created_at) }}</td>
                                <td>
                                    @if ($item->status == 1)
                                        <button type="button" class="btn btn--base bg--success"><i
                                                class="las la-check-circle"></i></button>

                                        <a href="{{ setRoute('admin.sell.coin.details', $item->id) }}"
                                            class="btn btn--base"><i class="las la-expand"></i></a>
                                    @else
                                        @include('admin.components.link.info-default', [
                                            'href' => setRoute('admin.sell.coin.details', $item->id),
                                            'permission' => 'admin.sell.coin.details',
                                        ])
                                    @endif
                                </td>
                               
                            </tr>
                        @empty
                            @include('admin.components.alerts.empty', ['colspan' => 8])
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ get_paginate($transactions) }}
        </div>
    </div>
@endsection

@push('script')
@endpush
