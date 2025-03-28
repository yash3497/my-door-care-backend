@extends('nanny.layouts.master')

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
    <div class="body-wrapper mb-80">
        <div class="nanny-chat">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="custom-card support-card">
                        <div class="support-card-wrapper">
                            <div class="card-header">
                                <div class="card-header-user-area">

                                    <img class="avatar"
                                        src="{{ get_image($support_ticket->nanny->user_image, 'user-profile') }}"
                                        alt="client">
                                    <div class="card-header-user-content">
                                        <h6 class="title">{{ $support_ticket->nanny->fullname }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="support-chat-area">
                                <div class="chat-container messages" style="">
                                    <ul>
                                        @foreach ($support_ticket->conversations ?? [] as $item)
                                            <li
                                                class="media media-chat @if ($item->sender_type == 'NANNY') media-chat-reverse sent @else replies @endif">
                                                <img class="avatar" src="{{ $item->senderImage }}" alt="Profile">
                                                <div class="media-body">
                                                    <p>{{ $item->message }}</p>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @include('admin.components.support-ticket.conversation.message-input', [
                                    'support_ticket' => $support_ticket,
                                ])

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('admin.components.support-ticket.conversation.connection-user', [
    'support_ticket' => $support_ticket,
    'route' => setRoute('nanny.support.ticket.messaage.send'),
])
