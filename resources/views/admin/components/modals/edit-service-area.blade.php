@if (admin_permission_by_name('admin.service.area.update'))
    <div id="service-area-edit" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Edit Service Area') }}</h5>
            </div>
            <div class="modal-form-data">
                <form class="modal-form" method="POST" action="{{ route('admin.service.area.update') }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="target" value="{{ old('target') }}">
                    <div class="row mb-10-none">


                        <div class="col-xl-12 col-lg-12 form-group">
                            @include('admin.components.form.input', [
                                'label' => 'Service Area*',
                                'name' => 'service_area',
                                'placeholder' => 'Ex: New York',
                                'value' => old('service_area'),
                            ])
                        </div>



                        <div
                            class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                            <button type="button" class="btn btn--danger modal-close">{{ __('Cancel') }}</button>
                            <button type="submit" class="btn btn--base">{{ __('Update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            openModalWhenError("service-area-edit", "#service-area-edit");

            $(document).on("click", ".edit-modal-button", function() {
                var oldData = JSON.parse($(this).parents("tr").attr("data-item"));
           
                var editModal = $("#service-area-edit");

                editModal.find("form").first().find("input[name=target]").val(oldData.id);
                editModal.find("input[name=service_area]").val(oldData.service_area);



                openModalBySelector("#service-area-edit");

            });
        </script>
    @endpush
@endif
