@extends('nanny.layouts.master')

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
                'url' => setRoute('nanny.dashboard'),
            ],
        ],
        'active' => __('Profile'),
    ])
@endsection

@section('content')
    <div class="body-wrapper ">
        <div class="row mb-20-none">
            <div class="col-xl-5 col-lg-12 mb-20">
                <div class="custom-card mt-10">
                    <div class="dashboard-header-wrapper">
                        <div class="header-title d-flex justify-content-between mb-3">
                            <h4 class="title">{{ __('Profile Settings') }}</h4>
                            <button type="button" class=" btn btn-danger rounded" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">{{ __('Account Delete') }}</button>
                        </div>
                    </div>
                    <div class="card-body profile-body-wrapper">
                        <form class="card-form" method="POST" action="{{ route('nanny.profile.update') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="profile-settings-wrapper">
                                <div class="preview-thumb profile-wallpaper">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview bg_img"
                                            data-background="{{ asset('public/frontend') }}/images/element/b1.png"
                                            style="background-image: url(&quot;{{ asset('public/frontend') }}/images/element/b1.png&quot;);">
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-thumb-content">
                                    <div class="preview-thumb profile-thumb">
                                        <div class="avatar-preview">
                                            <div class="profilePicPreview bg_img has-image"
                                                data-background="{{ auth()->user()->userImage }}"
                                                style="background-image: url({{ auth()->user()->userImage }});">
                                            </div>
                                        </div>
                                        <div class="avatar-edit">
                                            <input type="file" class="profilePicUpload" name="image"
                                                id="profilePicUpload2" accept=".png,.jpg,.jpeg">
                                            <label for="profilePicUpload2"><i class="las la-upload"></i></label>
                                        </div>
                                    </div>
                                    <div class="profile-content">
                                        <h6 class="username text--base">{{ auth()->user()->fullname }}</h6>
                                        <div class="reating-area">
                                            <div class="rating">{{ @$average_rating }} <span class="text--base">
                                                    ({{ @$completed_work }})
                                                    @for ($number = 1; $number <= $average_rating; $number++)
                                                        <i class="fas fa-star"></i>
                                                    @endfor
                                                </span>
                                            </div>
                                        </div>

                                        <ul class="user-info-list mt-md-2">
                                            <li><i class="las la-envelope"></i>{{ auth()->user()->email }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="profile-form-area">

                                <div class="row">
                                    <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                        @include('admin.components.form.input', [
                                            'label' => 'First Name<span>*</span>',
                                            'name' => 'firstname',
                                            'placeholder' => 'Enter Name...',
                                            'value' => old('firstname', auth()->user()->firstname),
                                        ])
                                    </div>
                                    <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                        @include('admin.components.form.input', [
                                            'label' => 'Last Name',
                                            'name' => 'lastname',
                                            'placeholder' => 'Enter Last Name...',
                                            'value' => old('lastname', auth()->user()->lastname),
                                        ])
                                    </div>
                                    <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                        @include('admin.components.form.input', [
                                            'label' => 'Email<span>*</span>',
                                            'name' => 'email',
                                            'placeholder' => 'Enter Email...',
                                            'value' => old('email', auth()->user()->email),
                                            'readonly' => true,
                                        ])
                                    </div>
                                    <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                        <label>{{ __('Phone') }}<span>*</span></label>

                                        <input type="text" class="form--control" placeholder="Enter Phone ..."
                                            name="mobile" value="{{ old('mobile', auth()->user()->mobile ?? '') }}">
                                    </div>

                                    <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                        <label class="">{{ __('Country') }}<span class="">*</span></label>
                                        <div class="form-item">
                                            <input id="country_selector"
                                                value="{{ old('country', auth()->user()->address->country ?? '') }}"
                                                name="country" type="text" class="form--control w-100">
                                        </div>

                                    </div>
                                    <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                        @include('admin.components.form.input', [
                                            'label' => 'City',
                                            'name' => 'city',
                                            'placeholder' => 'Enter City...',
                                            'value' => old('address', auth()->user()->address->city ?? ''),
                                        ])
                                    </div>
                                    <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                        @include('admin.components.form.input', [
                                            'label' => 'State',
                                            'name' => 'state',
                                            'placeholder' => 'Enter State...',
                                            'value' => old('address', auth()->user()->address->state ?? ''),
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
                                    <div class="my-3 col-12">
                                        <button type="submit" class="btn--base w-100">{{ __('Update') }}</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-7 col-lg-12 mb-20">
                <div class="custom-card mt-10">
                    <div class="dashboard-header-wrapper">
                        <h4 class="title">{{ __('Update Profession') }}</h4>
                    </div>
                    <div class="profetion-update">
                        <form action="{{ route('nanny.profile.profession.update') }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row pt-3">
                                <div class="col-12">
                                    <label for="firstname">{{ __('Select Profession') }}</label>
                                    <select class="nice-select select-area py-0 w-100 profession-select"
                                        id="profession_type" name="profession_type">

                                        <option value="1" {{ @$profession->profession_type == 1 ? 'selected' : '' }}>
                                            {{ __('Baby Sitter') }}</option>
                                        <option value="2" {{ @$profession->profession_type == 2 ? 'selected' : '' }}>
                                            {{ __('Pet Sitter') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="select-from-area">
                                <div class="baby-sister-from ptb-30 select-child" data-select-target="1"
                                    style="display: none;">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <div class="baby-gender">
                                                <label for="firstname">{{ __('Gender') }}</label>
                                                <select class="nice-select select-area py-0 w-100" name="baby_gender">
                                                    <option selected value="">Choose One</option>
                                                    @foreach (GENDER as $item)
                                                        <option
                                                            value="{{ $item }}"@if (@$profession->profession_type == 1) {{ $profession->profession_type_details->baby_gender == $item ? 'selected' : '' }} @endif>
                                                            {{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4">
                                            <div class="baby-gender">
                                                <label for="firstname">{{ __('Baby Age') }}</label>
                                                <select class="nice-select select-area py-0 w-100" name="baby_age">
                                                    <option selected disabled>{{ __('Choose One') }}</option>
                                                    @foreach (AGE as $item)
                                                        <option value="{{ $item }}"
                                                            @if ($profession->profession_type == 1) {{ $profession->profession_type_details->baby_age == $item ? 'selected' : '' }} @endif>
                                                            {{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4">
                                            <div class="baby-number">
                                                <label for="firstname">{{ __('Number Of Kid') }}</label>
                                                <select class="nice-select select-area py-0 w-100" name="baby_number">
                                                    <option selected disabled>Choose One</option>
                                                    @foreach (NUMBER as $item)
                                                        <option value="{{ $item }}"
                                                            @if ($profession->profession_type == 1) {{ $profession->profession_type_details->baby_number == $item ? 'selected' : '' }} @endif>
                                                            {{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pet-sister-from ptb-30 select-child" data-select-target="2"
                                    style="display: none;">
                                    <div class="row">
                                        <div class="col-12 mb-30">
                                            <div class="baby-gender">
                                                <label for="firstname">{{ __('Pet Type') }}</label>
                                                <select class="nice-select select-area py-0 w-100" name="pet_type">
                                                    <option selected disabled>{{ __('Choose One') }}</option>
                                                    @foreach (PET_TYPE as $item)
                                                        <option value="{{ $item }}"
                                                            @if ($profession->profession_type == 2) {{ $profession->profession_type_details->pet_type == $item ? 'selected' : '' }} @endif>
                                                            {{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4">
                                            <div class="baby-gender">
                                                <label for="firstname">{{ __('Pate Gender') }}</label>
                                                <select class="nice-select select-area py-0 w-100" name="gender">
                                                    <option selected disabled>{{ __('Choose One') }}</option>
                                                    @foreach (GENDER as $item)
                                                        <option value="{{ $item }}"
                                                            @if ($profession->profession_type == 2) {{ $profession->profession_type_details->gender == $item ? 'selected' : '' }} @endif>
                                                            {{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4">
                                            <div class="baby-gender">
                                                <label for="firstname">{{ __('Pate Age') }}</label>
                                                <select class="nice-select select-area py-0 w-100" name="age">
                                                    <option selected disabled>{{ __('Choose One') }}</option>
                                                    @foreach (AGE as $item)
                                                        <option value="{{ $item }}"
                                                            @if ($profession->profession_type == 2) {{ $profession->profession_type_details->age == $item ? 'selected' : '' }} @endif>
                                                            {{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4">
                                            <div class="baby-number">
                                                <label for="firstname">{{ __('Number of Pet') }}</label>
                                                <select class="nice-select select-area py-0 w-100" name="number">
                                                    <option selected disabled>{{ __('Choose One') }}</option>
                                                    @foreach (NUMBER as $item)
                                                        <option value="{{ $item }}"
                                                            @if ($profession->profession_type == 2) {{ $profession->profession_type_details->number == $item ? 'selected' : '' }} @endif>
                                                            {{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="work-deatils ptb-30">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="work-experience">
                                                <label for="firstname">{{ __('Work Experience') }}</label>
                                                <select class="nice-select select-area py-0 w-100" name="work_experience">
                                                    <option selected disabled>Choose One</option>
                                                    @foreach (AGE as $item)
                                                        <option value="{{ $item }}"
                                                            {{ $profession->work_experience == $item ? 'selected' : '' }}>
                                                            {{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="work-experience">
                                                <label for="firstname">{{ __('Work Capability') }}</label>
                                                <select class="nice-select select-area py-0 w-100" name="work_capability">
                                                    <option selected disabled>Choose One</option>
                                                    @foreach (WORK_CAPABILITY as $item)
                                                        <option value="{{ $item }}"
                                                            {{ $profession->work_capability == $item ? 'selected' : '' }}>
                                                            {{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="work-experience">
                                                <label for="firstname">{{ __('Service Area') }}</label>
                                                <select class="nice-select select-area py-0 w-100" name="service_area">
                                                    <option selected disabled>{{ __('Choose One') }}</option>
                                                    @if ($service_areas)
                                                        @foreach ($service_areas as $service_area)
                                                            <option value="{{ $service_area->slug }}"
                                                                {{ $profession->service_area == $service_area->slug ? 'selected' : '' }}>
                                                                {{ $service_area->service_area }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="work-experience">
                                                <label for="firstname">{{ __('Type of Charge') }}</label>
                                                <select class="nice-select select-area py-0 w-100" name="charge">
                                                    <option selected disabled>{{ __('Choose One') }}</option>
                                                    @foreach (CHARGE as $item)
                                                        <option value="{{ $item }}"
                                                            {{ $profession->charge == $item ? 'selected' : '' }}>
                                                            {{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12 pt-10">
                                            <label for="amount">{{ __('Charge') }} </label>
                                            <input type="text" id="amount" class="form--control charge-nanny"
                                                placeholder="Enter Amount" name="amount"
                                                value="{{ $profession->amount ?? '' }}" required>
                                            <select class="nice-select charge-amount">
                                                <option value="{{ get_default_currency_code() }}">
                                                    {{ get_default_currency_code() }}</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-12 col-md-12 pt-10">
                                            <label for="bio">{{ __('Bio') }} </label>
                                            <textarea class="form--control" id="bio" name="bio" placeholder="Write Something About You..">{{ $profession->bio ?? '' }}</textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="register-btn">
                                <button type="submit"
                                    class="btn--base w-100 text-center mt-2">{{ __('Profession Update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal user-modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="title">{{ __('Are you sure?') }}</h3>
                    <p>{{ __('Do you want to delete your account?') }}</p>
                </div>
                <div class="modal-footer border-none">
                    <form action="{{ route('nanny.profile.account.delete', auth()->user()->id) }}" method="POST">
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

    <script>
        $(".profession-select").change(function() {
            var targetItem = $(this).val();
            selectContainItem(targetItem);
        });

        $(document).ready(function() {
            var professionSelectedItem = $(".profession-select").val();
            selectContainItem(professionSelectedItem);
        });

        function selectContainItem(targetItem) {
            $(".select-child").slideUp(300);
            if (targetItem == null) return false;
            if (targetItem.length > 0) {
                var findTargetItem = $(".select-child");
                $.each(findTargetItem, function(index, item) {
                    if ($(item).attr("data-select-target") == targetItem) {
                        $(item).slideDown(300);
                    } else {
                        $(item).slideUp(300);
                    }
                })
            }
        }
    </script>
@endpush
