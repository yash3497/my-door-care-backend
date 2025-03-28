@extends('nanny.layouts.master')

@push('css')
    <style>
        .input-group input {
            height: 50px;
        }
    </style>
@endpush

@section('content')
    <div class="body-wrapper ">
        <div class="table-content">
            <div class="header-title">
                @include('user.components.welcome')
                <div class="send-add-form">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 col-md-12 col-12 form-area">
                            <div class="add-money-text pb-3">
                                <h4>{{ __('KYC Information') }} <span
                                        class="{{ $nanny->kycStringStatus->class }}">{{ $nanny->kycStringStatus->value }}</span>
                                </h4>

                            </div>
                            <div class="row">
                                @if ($nanny_kyc_data)
                                    @forelse ($nanny_kyc_data->data as $item)
                                        @if ($item->type == 'file')
                                            <div class="col-lg-6">
                                                <div class="kyc-img-part">
                                                    <div class="kyc-img">
                                                        <img src="{{ get_image($item->value, 'kyc-files') }}"
                                                            alt="img">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @empty

                                        <div class="col-lg-12">
                                            <div class="baybs-data">
                                                <p>{{ __('Data Not Found') }}</p>
                                            </div>
                                        </div>
                                    @endforelse
                                @endif
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
