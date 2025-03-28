@extends('user.layouts.master')

@push('css')
    <style>
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #fff;
        }
    </style>
@endpush


@section('content')
    <div class="body-wrapper ">
        <div class="table-content pb-120">
            <div class="row">
                @include('user.components.welcome')
                <div class="card-1 mb-30">
                    <form action="{{ route('user.add.baby.pet.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row pt-3">
                            <div class="col-12 mb-30">
                                <label for="profession_type">{{ __('Select Service') }}<span>*</span></label>
                                <select class="nice-select select-area py-0 w-100 profession-select" id="profession_type"
                                    name="profession_type">
                                    <option value="1">{{ __('Baby Sitter') }}</option>
                                    <option value="2">{{ __('Pet Sitter') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="select-from-area">
                            <div class="baby-sister-from ptb-20 select-child" data-select-target="1" style="display: none;">
                                <div class="row mb-10-none">
                                    <div class="col-lg-4 col-md-4 col-sm-6 mb-10">
                                        <div class="baby-gender">
                                            <label for="baby_name">{{ __('Baby Name') }} <span>*</span></label>
                                            <input name="baby_name" id="baby_name" type="text" class="form--control"
                                                placeholder="Ex: John Doe">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 mb-10">
                                        <div class="baby-gender">
                                            <label for="baby_gender">{{ __('Gender') }} <span>*</span></label>
                                            <select class="nice-select select-area py-0 w-100" id="baby_gender"
                                                name="baby_gender">
                                                <option selected value="">{{ __('Choose One') }} </option>
                                                @foreach (GENDER as $item)
                                                    <option value="{{ $item }}">{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-6 mb-10">
                                        <div class="baby-gender">
                                            <label for="baby_age">{{ __('Baby Age') }} <span>*</span></label>
                                            <input name="baby_age" id="baby_age" type="text" class="form--control"
                                                placeholder="Ex: 2 Years">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 mb-10">
                                        <label for="baby_food">{{ __('Baby Food') }} <span>*</span> </label>
                                        <textarea id="baby_food" name="baby_food" class="form-control text-area" placeholder="Ex: Eggs,Salmon " rows="3"></textarea>
                                    </div>


                                </div>
                            </div>
                            <div class="pet-sister-from ptb-30 select-child" data-select-target="2" style="display: none;">
                                <div class="row mb-10-none">
                                    <div class="col-lg-4 col-md-4 col-sm-6 mb-10">
                                        <div class="baby-gender">
                                            <label for="pet_name">{{ __('Pet Name') }} <span>*</span></label>
                                            <input id="pet_name" name="pet_name" type="text" class="form--control"
                                                placeholder="Ex: Bully">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 mb-10">
                                        <div class="baby-gender">
                                            <label for="firstname">{{ __('Pet Type') }} <span>*</span></label>
                                            <select class="nice-select select-area py-0 w-100" name="pet_type">
                                                <option selected disabled>{{ __('Choose One') }}</option>
                                                @foreach (PET_TYPE as $item)
                                                    <option value="{{ $item }}">{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 mb-10">
                                        <div class="baby-gender">
                                            <label for="pet_gender">{{ __('Pet Gender') }} <span>*</span></label>
                                            <select class="nice-select select-area py-0 w-100" id="pet_gender"
                                                name="pet_gender">
                                                <option selected disabled>{{ __('Choose One') }}</option>
                                                @foreach (GENDER as $item)
                                                    <option value="{{ $item }}">{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 mb-10">
                                        <div class="baby-gender">
                                            <label for="pet_breed">{{ __('Pet Breed') }} <span>*</span></label>
                                            <input name="pet_breed" type="text" class="form--control"
                                                placeholder="Enter Pet Breed">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 mb-10 ">
                                        <div class="baby-gender">
                                            <label for="pet_age">{{ __('Pet Age') }} <span>*</span></label>
                                            <input name="pet_age" type="text" class="form--control"
                                                placeholder="Ex: 2 Years">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 mb-10">
                                        <div class="baby-gender">
                                            <label for="pet_weight">{{ __('Pet Weight') }} <span>*</span></label>
                                            <input name="pet_weight" type="text" class="form--control"
                                                placeholder="Ex: 4 Kg">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <label for="pet_food">{{ __('Pet Food') }} <span>*</span> </label>
                                        <textarea id="pet_food" name="pet_food" class="form-control text-area" placeholder="Ex: Beef, Eggs" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="work-deatils">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        @include('admin.components.form.input-file', [
                                            'label' => 'Upload Picture *',
                                            'name' => 'image',
                                            'class' => 'file-holder',
                                        ])

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="register-btn mt-5">
                            <button type="submit" class="btn--base w-100 text-center">{{ __('Add Now') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- file holder js -->

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
