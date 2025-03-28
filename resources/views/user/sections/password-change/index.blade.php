@extends('user.layouts.master')

@push('css')
    <style>
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #fff;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('public/frontend') }}/css/countrySelect.css">
@endpush

@section('breadcrumb')
    @include('user.components.breadcrumb', [
        'breadcrumbs' => [
            [
                'name' => __('Dashboard'),
                'url' => setRoute('user.dashboard'),
            ],
        ],
        'active' => __('Profile'),
    ])
@endsection

@section('content')
    <div class="body-wrapper ">
        <div class="table-content pb-120">
            <div class="header-title">
                <div class="top-title">
                    <h3> <span>{{ __('Welcome Back,') }}</span> {{ auth()->user()->fullname }}</h3>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="forget-password">
                        <form class="card-form" action="{{ setRoute('user.profile.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 form-group show_hide_password">
                                    @include('admin.components.form.input', [
                                        'label' => 'Current Password<span>*</span>',
                                        'name' => 'current_password',
                                        'type' => 'password',
                                        'placeholder' => 'Enter Password...',
                                    ])
                                    <a href="" class="show-pass profile"><i class="fa fa-eye-slash"
                                            aria-hidden="true"></i></a>
                                </div>
                                <div class="col-xl-12 col-lg-12 form-group show_hide_password-2">
                                    @include('admin.components.form.input', [
                                        'label' => 'New Password<span>*</span>',
                                        'name' => 'password',
                                        'type' => 'password',
                                        'placeholder' => 'Enter Password...',
                                    ])
                                    <a href="" class="show-pass profile"><i class="fa fa-eye-slash"
                                            aria-hidden="true"></i></a>
                                </div>
                                <div class="col-xl-12 col-lg-12 form-group show_hide_password-3">
                                    @include('admin.components.form.input', [
                                        'label' => 'Confirm Password<span>*</span>',
                                        'name' => 'password_confirmation',
                                        'type' => 'password',
                                        'placeholder' => 'Enter Password...',
                                    ])
                                    <a href="" class="show-pass profile"><i class="fa fa-eye-slash"
                                            aria-hidden="true"></i></a>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12">
                                <button type="submit" class="btn--base w-100 btn-loading">{{__('Change')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
 
@endpush
