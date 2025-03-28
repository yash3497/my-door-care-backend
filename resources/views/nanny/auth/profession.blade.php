@extends('layouts.master')

@push('css')
@endpush

@section('content')
    <section class="login ptb-80">
        <div class="container">
            <div class="registion-section-area">
                <div class="register-header text-center pb-30">
                    <h2 class="title">{{ @$page_title }}</h2>
                </div>
                <form action="{{ route('nanny.authorize.profession.submit') }}" method="POST">
                    @csrf
                    <div class="row pt-3">
                        <div class="col-12">
                            <label for="firstname">Select Profession <span>*</span></label>
                            <select class="nice-select select-area py-0 w-100 profession-select" id="profession_type"
                                name="profession_type">
                                <option value="1">Baby Sitter</option>
                                <option value="2">Pet Sitter</option>
                            </select>
                        </div>
                    </div>
                    <div class="select-from-area">
                        <div class="baby-sister-from ptb-30 select-child" data-select-target="1" style="display: none;">
                            <div class="row">
                                <div class="col-lg-4 col-md-4">
                                    <div class="baby-gender">
                                        <label for="firstname">Gender <span>*</span></label>
                                        <select class="nice-select select-area py-0 w-100" name="baby_gender">
                                            <option selected value="">Choose One </option>
                                            @foreach (GENDER as $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="baby-gender">
                                        <label for="firstname">Baby Age <span>*</span></label>
                                        <select class="nice-select select-area py-0 w-100" name="baby_age">
                                            <option selected disabled>Choose One</option>
                                            @foreach (AGE as $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="baby-number">
                                        <label for="firstname">Number Of Kid <span>*</span></label>
                                        <select class="nice-select select-area py-0 w-100" name="baby_number">
                                            <option selected disabled>Choose One</option>
                                            @foreach (NUMBER as $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pet-sister-from ptb-30 select-child" data-select-target="2" style="display: none;">
                            <div class="row">
                                <div class="col-12 mb-30">
                                    <div class="baby-gender">
                                        <label for="firstname">Pet Type <span>*</span></label>
                                        <select class="nice-select select-area py-0 w-100" name="pet_type">
                                            <option selected disabled>Choose One</option>
                                            @foreach (PET_TYPE as $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="baby-gender">
                                        <label for="firstname">Pet Gender <span>*</span></label>
                                        <select class="nice-select select-area py-0 w-100" name="gender">
                                            <option selected disabled>Choose One</option>
                                            @foreach (GENDER as $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="baby-gender">
                                        <label for="firstname">Pet Age <span>*</span></label>
                                        <select class="nice-select select-area py-0 w-100" name="age">
                                            <option selected disabled>Choose One</option>
                                            @foreach (AGE as $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="baby-number">
                                        <label for="firstname">Number of Pet <span>*</span></label>
                                        <select class="nice-select select-area py-0 w-100" name="number">
                                            <option selected disabled>Choose One</option>
                                            @foreach (NUMBER as $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="work-deatils ptb-30">
                            <div class="row">
                                <div class="col-lg-4 col-md-4">
                                    <div class="work-experience">
                                        <label for="firstname">Work Experience <span>*</span></label>
                                        <select class="nice-select select-area py-0 w-100" name="work_experience">
                                            <option selected disabled>Choose One</option>
                                            @foreach (AGE as $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="work-experience">
                                        <label for="firstname">Work Capability <span>*</span></label>
                                        <select class="nice-select select-area py-0 w-100" name="work_capability">
                                            <option selected disabled>Choose One</option>
                                            @foreach (WORK_CAPABILITY as $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="work-experience">
                                        <label for="service_area">Service Area <span>*</span></label>
                                        <select class="nice-select select-area py-0 w-100" id="service_area"
                                            name="service_area">
                                            <option selected disabled>Choose One</option>
                                            @if ($service_areas)
                                                @foreach ($service_areas as $service_area)
                                                    <option value="{{ $service_area->slug }}">
                                                        {{ $service_area->service_area }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 pt-10">
                                    <div class="work-experience">
                                        <label for="charge">Type of Charge <span>*</span></label>
                                        <select class="nice-select select-area py-0 w-100" id="charge" name="charge">
                                            <option selected disabled>Choose One</option>
                                            @foreach (CHARGE as $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 pt-10">
                                    <label for="amount">Charge <span>*</span></label>
                                    <input type="number" id="amount" class="form--control charge-nanny"
                                        placeholder="Enter Amount" name="amount" value="{{ old('amount') }}" required>
                                    <select class="nice-select charge-amount">
                                        <option value="{{ get_default_currency_code() }}">
                                            {{ get_default_currency_code() }}</option>
                                    </select>
                                </div>

                                <div class="col-lg-12 col-md-12 pt-10">
                                    <label for="bio">Bio <span>*</span></label>
                                    <textarea class="form--control" id="bio" name="bio" placeholder="Write Somthing About You.."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="register-btn">
                        <button type="submit" class="btn--base w-100 text-center mt-2">{{ __('Register Now') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('script')
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
