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
                <!-- Card -->
                <div class="pt-20 pb-120">
                    <div class="dash-section-title mb-40 d-flex justify-content-between baby-add-baby-details">
                        <h4>{{ __('My Baby / Pet') }}</h4>
                        <a href="{{ route('user.add.baby.pet.create') }}" class="btn--base">{{ __('Add baby / Pets') }}</a>
                    </div>
                    <div class="row g-4">
                        @forelse ($baby_pets as $baby_pet)
                            <a href="javascript:void(0)" data-item="{{ $baby_pet }}"
                                data-image="{{ get_image($baby_pet->image, 'add-baby-pet') }}"
                                class="col-lg-3 col-xl-2 col-md-4 col-sm-6 mypetsBtn row_add_baby_pet mb-20">
                                <div class="my-card">

                                    <img src="{{ get_image($baby_pet->image, 'add-baby-pet') }}" alt="image">

                                    @if ($baby_pet->profession_type == 1)
                                        <h3>{{ $baby_pet->profession_type_details->baby_name }}</h3>
                                    @elseif ($baby_pet->profession_type == 2)
                                        <h3>{{ $baby_pet->profession_type_details->pet_name }}</h3>
                                    @endif
                                </div>
                            </a>
                        @empty
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="baybs-data">
                                        <p>{{ __('Data Not Found') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforelse


                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="mypetsmodal-1" tabindex="-1" aria-labelledby="mypetsmodalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="mypetsmodalLabel">{{ __('Baby Information') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body row">
                    <div class="col-lg-4 modal-thumb">
                        <img src="" class="d-flex mx-lg-0 mx-auto image" alt="image">
                        <h3 class="baby_name">--</h3>
                    </div>
                    <div class="col-lg-8">

                        <div class="d-flex justify-content-between item">
                            <h3>{{ __('Baby Name:') }}</h3>
                            <h3 class="baby_name">--</h3>
                        </div>
                        <div class="d-flex justify-content-between item">
                            <h3>{{ __('Baby Gender:') }}</h3>
                            <h3 class="baby_gender">--</h3>
                        </div>
                        <div class="d-flex justify-content-between item">
                            <h3>{{ __('Baby Age:') }}</h3>
                            <h3 class="baby_age">--</h3>
                        </div>
                        <div class="d-flex justify-content-between item">
                            <h3>{{ __('Baby Food:') }}</h3>
                            <h3 class="baby_food">--</h3>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <a href="" class="btn--base btn baby_pet_edit">{{ __('Edit') }}</a>

                    <button type="button" class="btn--base btn btn-1 delete-modal-button"
                        data-bs-dismiss="modal">{{ __('Delete') }}</button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="mypetsmodal-2" tabindex="-1" aria-labelledby="mypetsmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="mypetsmodalLabel">{{ __('Pet Information') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body row mb-30-none">
                    <div class="col-lg-4 modal-thumb mb-30">
                        <img src="" class="d-flex mx-lg-0 mx-auto image" alt="image">
                        <h3 class="pet_name">--</h3>
                    </div>
                    <div class="col-lg-8 mb-30">
                        <div class="d-flex justify-content-between item">
                            <h3>{{ __('Pet Type:') }}</h3>
                            <h3 class="pet_type">--</h3>
                        </div>
                        <div class="d-flex justify-content-between item">
                            <h3>{{ __('Pet Name:') }}</h3>
                            <h3 class="pet_name">--</h3>
                        </div>
                        <div class="d-flex justify-content-between item">
                            <h3>{{ __('Pet Age:') }}</h3>
                            <h3 class="pet_age">--</h3>
                        </div>
                        <div class="d-flex justify-content-between item">
                            <h3>{{ __('Pet Gender:') }}</h3>
                            <h3 class="pet_gender">--</h3>
                        </div>
                        <div class="d-flex justify-content-between item">
                            <h3>{{ __('Pet Weight:') }}</h3>
                            <h3 class="pet_weight">--</h3>
                        </div>
                        <div class="d-flex justify-content-between item">
                            <h3>{{ __('Pet Breed:') }}</h3>
                            <h3 class="pet_breed">--</h3>
                        </div>
                        <div class="d-flex justify-content-between item">
                            <h3>{{ __('Pet Food:') }}</h3>
                            <h3 class="pet_food">--</h3>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="" class="btn--base btn baby_pet_edit">{{ __('Edit') }}</a>
                    <button type="button" class="btn--base btn btn-1 delete-modal-button"
                        data-bs-dismiss="modal">{{ __('Delete') }}
                    </button>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- file holder js -->

    <script>
        (function($) {
            "use strict";
            $('.mypetsBtn').on('click', function() {
                var item = $(this).data('item');
                var modal = $('#mypetsmodal-' + item.profession_type);
                var image = $(this).data('image');
                modal.find('.image').attr('src', image);
                var id = item.id;
                var url = "{{ url('user/add-baby-pet/edit') }}/" + id;
                modal.find('.baby_pet_edit').attr('href', url);

                modal.find('.pet_type').text(item.profession_type_details.pet_type);
                modal.find('.pet_name').text(item.profession_type_details.pet_name);
                modal.find('.pet_age').text(item.profession_type_details.pet_age);
                modal.find('.pet_weight').text(item.profession_type_details.pet_weight);
                modal.find('.pet_breed').text(item.profession_type_details.pet_breed);
                modal.find('.pet_gender').text(item.profession_type_details.pet_gender);
                modal.find('.pet_food').text(item.profession_type_details.pet_food);

                modal.find('.baby_name').text(item.profession_type_details.baby_name);
                modal.find('.baby_gender').text(item.profession_type_details.baby_gender);
                modal.find('.baby_age').text(item.profession_type_details.baby_age);
                modal.find('.baby_food').text(item.profession_type_details.baby_food);

                modal.modal('show');
            });
        })(jQuery);
    </script>
    <script>
        $(document).on("click", ".delete-modal-button", function() {
            var oldData = $('.row_add_baby_pet').data('item');

            var actionRoute = "{{ route('user.add.baby.pet.delete') }}";
            var target = oldData.id;
            var name = oldData.profession_type_details.pet_name ?? oldData.profession_type_details.baby_name;
            var message = `Are you sure to remove <strong>${name}</strong>?`;
            openDeleteModal(actionRoute, target, message);
        });
    </script>
@endpush
