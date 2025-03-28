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
        'active' => __('Sell Coin Details'),
    ])
@endsection

@section('content')
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title">{{ __('Sell Coin Details') }}</h6>
        </div>
        <div class="card-body">
            <form class="card-form">
                <div class="row align-items-center mb-10-none">
                    <div class="col-xl-4 col-lg-4 form-group">
                        <ul class="user-profile-list-two">
                            <li class="one">{{__('Date')}}: <span>{{ dateFormat('d M y h:i:s A', $data->created_at) }}</span></li>
                            <li class="two">{{__('TRX ID')}}: <span>{{ @$data->trx_id }}</span></li>
                            <li class="three">{{__('Email')}}: <span>{{ isset($data->user) ? $data->user->email : 'N/A' }}</span>
                            </li>
                            <li class="four">{{__('Method')}}: <span>{{ @$data->currency->name }}</span></li>
                            <li class="five">{{__('Amount')}}: <span>{{ number_format(@$data->request_amount, 2) }}
                                    {{ $data->details->total_info->charge->receiver_method_code }}</span></li>
                        </ul>
                    </div>

                    <div class="col-xl-4 col-lg-4 form-group">
                        <div class="user-profile-thumb">
                            <img src="{{ get_image($data->user->image, 'user-profile') }}" alt="payment">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 form-group">
                        <ul class="user-profile-list two">
                            <li class="one">{{__('Charge')}}:
                                <span>{{ number_format(@$data->details->total_info->charge->rtotal_charge, 2) }}
                                    {{ @$data->details->total_info->charge->receiver_method_code }}</span>
                            </li>
                            <li class="four">Conversion:
                                <span>{{ number_format(@$data->details->total_info->charge->convirsion_amount, 2) }}
                                    {{ @$data->details->total_info->charge->receiver_method_code }}</span>
                            </li>

                            <li class="three">Rate: <span>1 {{ get_default_currency_code() }} =
                                    {{ number_format(@$data->details->total_info->charge->exchange_rate, 2) }}
                                    {{ @$data->details->total_info->charge->sender_method_code }}</span></li>
                            <li class="two">Will Get:
                                <span>{{ number_format(@$data->details->total_info->charge->will_get, 2) }}
                                    {{ @$data->details->total_info->charge->sender_method_code }}</span>
                            </li>

                            <li class="five">Status: <span
                                    class="{{ @$data->stringStatus->class }}">{{ @$data->stringStatus->value }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (@$data->status == 2)
        <div class="custom-card mt-15">

            <div class="card-body">
                <h3 class="title">Sender Info</h3>
                <hr>
                <ul class="product-sales-info">
                    @foreach ($data->details->sender_input ?? [] as $item)
                        <li>
                            @if ($item->type == 'file')
                                @php
                                    $file_link = get_file_link('kyc-files', $item->value);
                                @endphp
                                <span class="kyc-title">{{ $item->label }}:</span>
                                @if (its_image($item->value))
                                    <div class="kyc-image ">
                                        <img class="img-fluid" width="200px" src="{{ $file_link }}"
                                            alt="{{ $item->label }}">
                                    </div>
                                @else
                                    <span class="text--danger">
                                        @php
                                            $file_info = get_file_basename_ext_from_link($file_link);
                                        @endphp
                                        <a href="{{ setRoute('file.download', ['kyc-files', $item->value]) }}">
                                            {{ Str::substr($file_info->base_name ?? '', 0, 20) . '...' . $file_info->extension ?? '' }}
                                        </a>
                                    </span>
                                @endif
                            @else
                                <span class="kyc-title">{{ $item->label }}:</span>
                                <span>{{ $item->value }}</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
                <h3 class="title mt-4">Receiver Info</h3>
                <hr>
                <ul class="product-sales-info">
                    @foreach ($data->details->total_info->receiver_details ?? [] as $item)
                        <li>
                            @if ($item->type == 'file')
                                @php
                                    $file_link = get_file_link('kyc-files', $item->value);
                                @endphp
                                <span class="kyc-title">{{ $item->label }}:</span>
                                @if (its_image($item->value))
                                    <div class="kyc-image ">
                                        <img class="img-fluid" width="200px" src="{{ $file_link }}"
                                            alt="{{ $item->label }}">
                                    </div>
                                @else
                                    <span class="text--danger">
                                        @php
                                            $file_info = get_file_basename_ext_from_link($file_link);
                                        @endphp
                                        <a href="{{ setRoute('file.download', ['kyc-files', $item->value]) }}">
                                            {{ Str::substr($file_info->base_name ?? '', 0, 20) . '...' . $file_info->extension ?? '' }}
                                        </a>
                                    </span>
                                @endif
                            @else
                                <span class="kyc-title">{{ $item->label }}:</span>
                                <span>{{ $item->value }}</span>
                            @endif
                        </li>
                    @endforeach
                </ul>

                <div class="product-sales-btn">
                    <button type="button" class="btn btn--base approvedBtn">Approve</button>
                    <button type="button" class="btn btn--danger rejectBtn">Reject</button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="approvedModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header p-3" id="approvedModalLabel">
                        <h5 class="modal-title">Approved Confirmation ( <span
                                class="fw-bold text-danger">{{ number_format(@$data->request_amount, 2) }}
                                {{ get_default_currency_code() }}</span> )</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="modal-form" action="{{ setRoute('admin.sell.coin.approved') }}" method="POST">

                            @csrf
                            @method('PUT')
                            <div class="row mb-10-none">
                                <div class="col-xl-12 col-lg-12 form-group">
                                    <input type="hidden" name="id" value={{ @$data->id }}>
                                    <p>Are you sure to approved this request?</p>
                                </div>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn--base btn-loading">Approved</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="rejectModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header p-3" id="rejectModalLabel">
                        <h5 class="modal-title">Rejection Confirmation ( <span
                                class="fw-bold text-danger">{{ number_format(@$data->request_amount, 2) }}
                                {{ get_default_currency_code() }}</span> )</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="modal-form" action="{{ setRoute('admin.sell.coin.rejected') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row mb-10-none">
                                <div class="col-xl-12 col-lg-12 form-group">
                                    <input type="hidden" name="id" value={{ @$data->id }}>
                                    @include('admin.components.form.textarea', [
                                        'label' => 'Explain Rejection Reason*',
                                        'name' => 'reject_reason',
                                        'value' => old('reject_reason'),
                                    ])
                                </div>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn--base">Confirm</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if (@$data->status == 4)
        <div class="custom-card mt-15">

            <div class="card-body">
                <h3 class="title">{{__('Rejection Info')}}</h3>
                <hr>


                <p>
                    @if (@$data->reject_reason != '')
                        {{ @$data->reject_reason }}
                    @endif
                </p>


            </div>
        </div>

        <div class="modal fade" id="approvedModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header p-3" id="approvedModalLabel">
                        <h5 class="modal-title">Approved Confirmation ( <span
                                class="fw-bold text-danger">{{ number_format(@$data->request_amount, 2) }}
                                {{ get_default_currency_code() }}</span> )</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="modal-form" action="{{ setRoute('admin.sell.coin.approved') }}" method="POST">

                            @csrf
                            @method('PUT')
                            <div class="row mb-10-none">
                                <div class="col-xl-12 col-lg-12 form-group">
                                    <input type="hidden" name="id" value={{ @$data->id }}>
                                    <p>Are you sure to approved this request?</p>
                                </div>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn--base btn-loading">Approved</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="rejectModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header p-3" id="rejectModalLabel">
                        <h5 class="modal-title">Rejection Confirmation ( <span
                                class="fw-bold text-danger">{{ number_format(@$data->request_amount, 2) }}
                                {{ get_default_currency_code() }}</span> )</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="modal-form" action="{{ setRoute('admin.sell.coin.rejected') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row mb-10-none">
                                <div class="col-xl-12 col-lg-12 form-group">
                                    <input type="hidden" name="id" value={{ @$data->id }}>
                                    @include('admin.components.form.textarea', [
                                        'label' => 'Explain Rejection Reason*',
                                        'name' => 'reject_reason',
                                        'value' => old('reject_reason'),
                                    ])
                                </div>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn--base">Confirm</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            @if ($errors->any())
                var modal = $('#rejectModal');
                modal.modal('show');
            @endif

            $('.approvedBtn').on('click', function() {
                var modal = $('#approvedModal');
                modal.modal('show');
            });
            $('.rejectBtn').on('click', function() {
                var modal = $('#rejectModal');
                modal.modal('show');
            });
        });
    </script>
@endpush
