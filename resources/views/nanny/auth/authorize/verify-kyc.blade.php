@extends('layouts.master')

@push('css')
@endpush

@section('content')
    <div class="send-add-form ptb-80">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-8 col-12 form-area">
                <div class="add-money-text pb-3">
                    <h4>{{ __('KYC Verification') }}</h4>
                </div>
                <form action="{{ route('nanny.authorize.kyc.submit') }}" class="account-form nanny-kyc-form" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row ml-b-20">
                        @include('user.components.generate-kyc-fields', ['fields' => $kyc_fields])


                        <div class="col-lg-12 form-group text-center">
                            <button type="submit" class="btn--base w-100">{{ __('Submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
@endpush
