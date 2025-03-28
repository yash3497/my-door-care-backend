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
        <div class="table-content">
            <div class="row">
                @include('user.components.welcome')
                <div>
                    <div class="p-4 card-user mt-30 mb-40">
                        <div class="row g-5 d-flex justify-content-center">
                            <div class="col-lg-5 col-md-12 col-12">
                                <div class="header-title d-flex justify-content-between mb-3">
                                    <h4 class="title">{{ __('Profile Settings') }}</h4>
                                    <button type="button" class=" btn btn-danger rounded" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">{{ __('Account Delete') }}</button>
                                </div>
                                <div class="user-profile-img">
                                    <img class=" d-block mx-auto" src="{{ auth()->user()->userImage }}" alt="img">
                                </div>
                                <div>
                                    <div class="d-flex justify-content-between mt-4 rounded-2 p-2 user-card">
                                        <p class=" m-0 fw-bold">{{ __('Name') }}:</p>
                                        <p class=" m-0 ">{{ auth()->user()->fullname }}</p>
                                    </div>
                                    <div class="d-flex justify-content-between mt-4 rounded-2 p-2 user-card">
                                        <p class=" m-0 fw-bold">{{ __('Username') }}:</p>
                                        <p class=" m-0 ">{{ auth()->user()->username }}</p>
                                    </div>
                                    <div class="d-flex justify-content-between mt-4 rounded-2 p-2 user-card">
                                        <p class=" m-0 fw-bold">{{ __('Email') }}:</p>
                                        <p class=" m-0 ">{{ auth()->user()->email }}</p>
                                    </div>
                                    <div class="d-flex justify-content-between mt-4 rounded-2 p-2 user-card">
                                        <p class=" m-0 fw-bold">{{ __('Phone') }}:</p>
                                        <p class=" m-0 ">{{ auth()->user()->mobile ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-12 col-12 pt-4">
                                <form class="card-form" method="POST" action="{{ setRoute('user.profile.update') }} "
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row g-4k">
                                        <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                            @include('admin.components.form.input', [
                                                'label' => 'First Name<span>*</span>',
                                                'name' => 'firstname',
                                                'placeholder' => 'Enter First Name...',
                                                'value' => old('firstname', auth()->user()->firstname),
                                            ])
                                        </div>
                                        <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                            @include('admin.components.form.input', [
                                                'label' => 'Last Name<span>*</span>',
                                                'name' => 'lastname',
                                                'placeholder' => 'Enter Last Name...',
                                                'value' => old('firstname', auth()->user()->lastname),
                                            ])
                                        </div>
                                        <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                            <label>{{ __('Phone') }}<span>*</span></label>
                                            <input type="text" class="form--control" placeholder="Enter Phone ..."
                                                name="mobile" value="{{ old('mobile', auth()->user()->mobile ?? '') }}">
                                        </div>
                                        <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                            <label class="">{{ __('Country') }}<span
                                                    class="text-danger">*</span></label>
                                            <div class="form-item">
                                                <input id="country_selector"
                                                    value="{{ old('country', auth()->user()->address->country ?? '') }}"
                                                    name="country" type="text" class="form--control w-100">
                                            </div>
                                        </div>



                                        <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                            @include('admin.components.form.input', [
                                                'label' => 'City*',
                                                'name' => 'city',
                                                'placeholder' => 'Enter City...',
                                                'value' => old(
                                                    'town',
                                                    Str::title(auth()->user()->address->city) ?? ''),
                                            ])
                                        </div>
                                        <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                            @include('admin.components.form.input', [
                                                'label' => 'State',
                                                'name' => 'state',
                                                'placeholder' => 'Enter State...',
                                                'value' => old('state', auth()->user()->address->state ?? ''),
                                            ])
                                        </div>
                                        <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                            @include('admin.components.form.input', [
                                                'label' => 'Address',
                                                'name' => 'address',
                                                'placeholder' => 'Enter Address...',
                                                'value' => old('address', auth()->user()->address->address ?? ''),
                                            ])
                                        </div>
                                        <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                            @include('admin.components.form.input', [
                                                'label' => 'Zip Code',
                                                'name' => 'zip_code',
                                                'placeholder' => 'Enter Zip...',
                                                'value' => old('zip_code', auth()->user()->address->zip ?? ''),
                                            ])
                                        </div>

                                        <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                            @include('admin.components.form.input-file', [
                                                'label' => 'Image:',
                                                'name' => 'image',
                                                'class' => 'file-holder',
                                                'old_files_path' => files_asset_path('user-profile'),
                                                'old_files' => auth()->user()->image ?? '',
                                            ])

                                        </div>

                                        <div class="my-3 col-12">
                                            <button type="submit" class="btn--base w-100">{{ __('Update') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- profile delete Modal -->
    <div class="modal user-modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="title">{{ __('Are you sure?') }}</h3>
                    <p>{{ __('Do you want to delete your account?') }}</p>
                </div>
                <div class="modal-footer border-none">
                    <form action="{{ route('user.profile.account.delete', auth()->user()->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn--base">{{ __('Confirm') }}</button>
                    </form>
                    <button class="btn--base close-btn ms-auto" data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('public/frontend') }}/js/countrySelect.js"></script>

    <script>
        $(document).ready(function() {
            $(".show_hide_password .show-pass").on('click', function(event) {
                event.preventDefault();
                if ($(this).parent().find("input").attr("type") == "text") {
                    $(this).parent().find("input").attr('type', 'password');
                    $(this).find("i").addClass("fa-eye-slash");
                    $(this).find("i").removeClass("fa-eye");
                } else if ($(this).parent().find("input").attr("type") == "password") {
                    $(this).parent().find("input").attr('type', 'text');
                    $(this).find("i").removeClass("fa-eye-slash");
                    $(this).find("i").addClass("fa-eye");
                }
            });
        });
    </script>



    <script>
        $("#country_selector").countrySelect({
            defaultCountry: "us",
            responsiveDropdown: true,
        });
    </script>
@endpush
