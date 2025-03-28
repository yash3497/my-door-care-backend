@if (admin_permission_by_name('admin.service.area.store'))
    <div id="service-area-add" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Add Service Area') }}</h5>
            </div>
            <div class="modal-form-data">
                <form class="modal-form" method="POST" action="{{ route('admin.service.area.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-10-none">


                        <div class="col-xl-12 col-lg-12 form-group">
                            @include('admin.components.form.input', [
                                'label' => 'Area*',
                                'name' => 'service_area',
                                'placeholder' => 'Ex: New York',
                                'type' => 'text',
                                'value' => old('service_area'),
                            ])
                        </div>

                        <div
                            class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                            <button type="button" class="btn btn--danger modal-close">{{ __('Cancel') }}</button>
                            <button type="submit" class="btn btn--base">{{ __('Add') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            openModalWhenError("service-area-add", "#service-area-add");

            function placeRandomPassword(clickedButton, placeInput) {
                $(clickedButton).click(function() {
                    var generateRandomPassword = makeRandomString(10);
                    $(placeInput).val(generateRandomPassword);
                });
            }
            placeRandomPassword(".rand_password_generator", ".place_random_password");
        </script>
    @endpush
@endif
