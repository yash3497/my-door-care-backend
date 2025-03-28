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
    <div class="body-wrapper ">
        <div class="table-content">
            <div class="row">
                @include('user.components.welcome')

                <div class="card-1 mb-30">
                    <div class="row justify-content-center form-area">
                        <div class="col-lg-9 col-md-10 col-12">
                            <div class="form-area-tab">
                                <div class="user-text pb-4">
                                    <h4>{{ __($page_title) ?? 'Create Ticket' }}</h4>
                                </div>
                                <form class="card-form" action="{{ route('nanny.support.ticket.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 form-group">
                                            @include('admin.components.form.input', [
                                                'label' => 'Subject<span>*</span>',
                                                'name' => 'subject',
                                                'placeholder' => 'Enter Subject...',
                                            ])
                                        </div>
                                        <div class="col-xl-12 col-lg-12 form-group">
                                            @include('admin.components.form.textarea', [
                                                'label' => "Message <span class='text--base'>*</span>",
                                                'name' => 'desc',
                                                'placeholder' => 'Write Here…',
                                            ])
                                        </div>
                                        <div class="col-xl-4 col-lg-4 form-group">

                                            @include('admin.components.form.input-file', [
                                                'label' => 'Attachments:',
                                                'name' => 'attachment[]',
                                                'class' => 'file-holder',
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12">
                                        <button type="submit"
                                            class="btn--base w-100">{{ __('Add Support Ticket') }}</button>
                                    </div>
                                </form>
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
