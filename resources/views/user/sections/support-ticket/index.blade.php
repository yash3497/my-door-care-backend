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
        'active' => __('Support Tickets'),
    ])
@endsection

@section('content')
    <div class="body-wrapper ">
        <div class="table-content">
            <div class="row">
                <div class="header-title">
                    <div class="top-title">
                        <h3> <span>{{ __('Welcome Back') }},</span> {{ auth()->user()->fullname }}</h3>
                    </div>
                    <!-- table -->
                    <div class="table-area pt-20 pb-30">
                        <div class="d-flex justify-content-between align-items-center my-escrow">
                            <div class="dash-section-title">
                                <h4>{{ __('Support Ticket') }}</h4>
                            </div>
                            <div>
                                <a href="{{ route('user.support.ticket.create') }}" class="btn--base"><i
                                        class="las la-plus me-1"></i>{{ __('Add New') }}</a>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-xl-12">
                                <div class="table-area">
                                    <table class="custom-table tickets-tabile-area">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Ticket Number') }}</th>
                                                <th>{{ __('Subject') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('Date') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($support_tickets as $support_ticket)
                                                <tr>
                                                    <td data-label="Ticket Number">{{ $support_ticket->token }}
                                                    </td>
                                                    <td data-label="Subject">{{ $support_ticket->subject }}
                                                    </td>
                                                    <td data-label="Status">
                                                        <span
                                                            class="{{ $support_ticket->stringStatus->class }}">{{ $support_ticket->stringStatus->value }}</span>
                                                    </td>
                                                    <td data-label="Date">
                                                        {{ $support_ticket->created_at->format('d-m-Y / H:i A') }}
                                                    </td>
                                                    <td data-label="Action">

                                                        <a href="{{ route('user.support.ticket.conversation', encrypt($support_ticket->id)) }}"
                                                            class="s-icon me-0 me-xl-3"><i class="las la-eye"></i></a>
                                                    </td>
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
                                {{ get_paginate($support_tickets) }}


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script></script>
@endpush
