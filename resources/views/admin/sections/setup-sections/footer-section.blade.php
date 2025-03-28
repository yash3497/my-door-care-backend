@php
    $default_lang_code = language_const()::NOT_REMOVABLE;
    $system_default_lang = get_default_language_code();
    $languages_for_js_use = $languages->toJson();
@endphp
@extends('admin.layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('public/backend/css/fontawesome-iconpicker.min.css') }}">
    <style>
        .fileholder {
            min-height: 374px !important;
        }

        .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,
        .fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view {
            height: 330px !important;
        }
    </style>
@endpush

@section('page-title')
    @include('admin.components.page-title', ['title' => __($page_title)])
@endsection

@section('breadcrumb')
    @include('admin.components.breadcrumb', [
        'breadcrumbs' => [
            [
                'name' => __('Dashboard'),
                'url' => setRoute('admin.dashboard'),
            ],
        ],
        'active' => __('Footer Section'),
    ])
@endsection

@section('content')
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title">{{ __($page_title) }}</h6>
        </div>
        <div class="card-body">
            <form class="card-form" action="{{ setRoute('admin.setup.sections.section.update', $slug) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-center mb-10-none">
                    <div class="col-xl-12 col-lg-12">
                        <div class="product-tab">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link @if (get_default_language_code() == language_const()::NOT_REMOVABLE) active @endif"
                                        id="english-tab" data-bs-toggle="tab" data-bs-target="#english" type="button"
                                        role="tab" aria-controls="english" aria-selected="false">English</button>
                                    @foreach ($languages as $item)
                                        <button class="nav-link @if (get_default_language_code() == $item->code) active @endif"
                                            id="{{ $item->name }}-tab" data-bs-toggle="tab"
                                            data-bs-target="#{{ $item->name }}" type="button" role="tab"
                                            aria-controls="{{ $item->name }}"
                                            aria-selected="true">{{ $item->name }}</button>
                                    @endforeach
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane @if (get_default_language_code() == language_const()::NOT_REMOVABLE) fade show active @endif"
                                    id="english" role="tabpanel" aria-labelledby="english-tab">

                                    <div class="form-group">
                                        @include('admin.components.form.textarea', [
                                            'label' => 'Footer Description*',
                                            'name' => $default_lang_code . '_footer_description',
                                            'value' => old(
                                                $default_lang_code . '_footer_description',
                                                $data->value->language->$default_lang_code->footer_description ??
                                                    ''),
                                        ])
                                    </div>
                                    <div class="form-group">
                                        @include('admin.components.form.textarea', [
                                            'label' => 'Newsletter Description*',
                                            'name' => $default_lang_code . '_newsletter_description',
                                            'value' => old(
                                                $default_lang_code . '_newsletter_description',
                                                $data->value->language->$default_lang_code->newsletter_description ?? ''),
                                        ])
                                    </div>


                                </div>

                                @foreach ($languages as $item)
                                    @php
                                        $lang_code = $item->code;
                                    @endphp
                                    <div class="tab-pane @if (get_default_language_code() == $item->code) fade show active @endif"
                                        id="{{ $item->name }}" role="tabpanel" aria-labelledby="english-tab">

                                        <div class="form-group">
                                            @include('admin.components.form.textarea', [
                                                'label' => 'Footer Description*',
                                                'name' => $item->code . '_footer_description',
                                                'value' => old(
                                                    $item->code . '_footer_description',
                                                    $data->value->language->$lang_code->footer_description ?? ''),
                                            ])
                                        </div>
                                        <div class="form-group">
                                            @include('admin.components.form.textarea', [
                                                'label' => 'Newsletter Description*',
                                                'name' => $item->code . '_newsletter_description',
                                                'value' => old(
                                                    $item->code . '_newsletter_description',
                                                    $data->value->language->$lang_code->newsletter_description ??
                                                        ''),
                                            ])
                                        </div>


                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.button.form-btn', [
                            'class' => 'w-100 btn-loading',
                            'text' => 'Submit',
                            'permission' => 'admin.setup.sections.section.update',
                        ])
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="table-area mt-15">
        <div class="table-wrapper">
            <div class="table-header justify-content-end">
                <div class="table-btn-area">
                    <a href="#footer-add" class="btn--base modal-btn"><i class="fas fa-plus me-1"></i>
                        {{ __('Add Social Link') }}</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Link</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data->value->items ?? [] as $key => $item)
                            <tr data-item="{{ json_encode($item) }}">

                                <td><a href="{{ $item->language->$system_default_lang->link ?? '' }}"
                                        class="text--danger">{{ $item->language->$system_default_lang->item_title ?? '' }}</a>
                                </td>
                                <td><a href="{{ $item->language->$system_default_lang->link ?? '' }}"
                                        class="text--danger">{{ $item->language->$system_default_lang->item_link ?? '' }}</a>
                                </td>
                                <td>
                                    <button class="btn btn--base edit-modal-button"><i
                                            class="las la-pencil-alt"></i></button>
                                    <button class="btn btn--base btn--danger delete-modal-button"><i
                                            class="las la-trash-alt"></i></button>
                                </td>
                            </tr>
                        @empty
                            @include('admin.components.alerts.empty', ['colspan' => 4])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('admin.components.modals.site-section.add-footer-item')

    <div id="footer-edit" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header px-0">
                <h5 class="modal-title">{{ __('Edit Social Link') }}</h5>
            </div>
            <div class="modal-form-data">
                <form class="modal-form" method="POST"
                    action="{{ setRoute('admin.setup.sections.section.item.update', $slug) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="target" value="{{ old('target') }}">
                    <div class="row mb-10-none mt-3">
                        <div class="language-tab">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link @if (get_default_language_code() == language_const()::NOT_REMOVABLE) active @endif"
                                        id="edit-modal-english-tab" data-bs-toggle="tab"
                                        data-bs-target="#edit-modal-english" type="button" role="tab"
                                        aria-controls="edit-modal-english" aria-selected="false">English</button>
                                    @foreach ($languages as $item)
                                        <button class="nav-link @if (get_default_language_code() == $item->code) active @endif"
                                            id="edit-modal-{{ $item->name }}-tab" data-bs-toggle="tab"
                                            data-bs-target="#edit-modal-{{ $item->name }}" type="button" role="tab"
                                            aria-controls="edit-modal-{{ $item->name }}"
                                            aria-selected="true">{{ $item->name }}</button>
                                    @endforeach

                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">

                                <div class="tab-pane @if (get_default_language_code() == language_const()::NOT_REMOVABLE) fade show active @endif"
                                    id="edit-modal-english" role="tabpanel" aria-labelledby="edit-modal-english-tab">
                                    <div class="form-group">
                                        @include('admin.components.form.input', [
                                            'label' => 'Social Icon*',
                                            'name' => $default_lang_code . '_item_social_icon_edit',
                                            'value' => old(
                                                $default_lang_code . '_item_social_icon_edit',
                                                $data->value->language->$default_lang_code->item_social_icon ?? ''),
                                            'class' =>
                                                'form--control icp icp-auto iconpicker-element iconpicker-input',
                                        ])
                                    </div>
                                    <div class="form-group">
                                        @include('admin.components.form.input', [
                                            'label' => 'Title*',
                                            'name' => $default_lang_code . '_item_title_edit',
                                            'value' => old(
                                                $default_lang_code . '_item_title_edit',
                                                $data->value->language->$default_lang_code->item_title ?? ''),
                                        ])
                                    </div>

                                    <div class="form-group">
                                        @include('admin.components.form.input', [
                                            'label' => 'Link*',
                                            'name' => $default_lang_code . '_item_link_edit',
                                            'value' => old(
                                                $default_lang_code . '_item_link_edit',
                                                $data->value->language->$default_lang_code->item_link ?? ''),
                                        ])
                                    </div>
                                </div>

                                @foreach ($languages as $item)
                                    @php
                                        $lang_code = $item->code;
                                    @endphp
                                    <div class="tab-pane @if (get_default_language_code() == $item->code) fade show active @endif"
                                        id="edit-modal-{{ $item->name }}" role="tabpanel"
                                        aria-labelledby="edit-modal-{{ $item->name }}-tab">
                                        <div class="form-group">
                                            @include('admin.components.form.input', [
                                                'label' => 'Social Icon*',
                                                'name' => $lang_code . '_item_social_icon_edit',
                                                'value' => old(
                                                    $lang_code . '_item_social_icon_edit',
                                                    $data->value->language->$lang_code->item_social_icon ?? ''),
                                                'class' =>
                                                    'form--control icp icp-auto iconpicker-element iconpicker-input',
                                            ])
                                        </div>
                                        <div class="form-group">
                                            @include('admin.components.form.input', [
                                                'label' => 'Title*',
                                                'name' => $lang_code . '_item_title_edit',
                                                'value' => old(
                                                    $lang_code . '_item_title_edit',
                                                    $data->value->language->$lang_code->item_title ?? ''),
                                            ])
                                        </div>

                                        <div class="form-group">
                                            @include('admin.components.form.input', [
                                                'label' => 'Link*',
                                                'name' => $lang_code . '_item_link_edit',
                                                'value' => old(
                                                    $lang_code . '_item_link_edit',
                                                    $data->value->language->$lang_code->item_link ?? ''),
                                            ])
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                            <button type="button" class="btn btn--danger modal-close">{{ __('Cancel') }}</button>
                            <button type="submit" class="btn btn--base">{{ __('Update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('public/backend/js/fontawesome-iconpicker.js') }}"></script>
    <script>
        // icon picker
        $('.icp-auto').iconpicker();
    </script>
    <script>
        openModalWhenError("footer-add", "#footer-add");
        openModalWhenError("footer-edit", "#footer-edit");

        var default_language = "{{ $default_lang_code }}";
        var system_default_language = "{{ $system_default_lang }}";
        var languages = "{{ $languages_for_js_use }}";
        languages = JSON.parse(languages.replace(/&quot;/g, '"'));

        $(".edit-modal-button").click(function() {
            var oldData = JSON.parse($(this).parents("tr").attr("data-item"));
            var editModal = $("#footer-edit");



            editModal.find("form").first().find("input[name=target]").val(oldData.id);
            editModal.find("input[name=" + default_language + "_item_title_edit]").val(oldData.language[
                    default_language]
                .item_title);
            editModal.find("input[name=" + default_language + "_item_social_icon_edit]").val(oldData.language[
                default_language].item_social_icon);
            editModal.find("input[name=" + default_language + "_item_link_edit]").val(oldData.language[
                    default_language]
                .item_link);

            $.each(languages, function(index, item) {
                editModal.find("input[name=" + item.code + "_item_title_edit]").val(oldData.language[item
                    .code]?.item_title);
                editModal.find("input[name=" + item.code + "_item_social_icon_edit]").val(oldData.language[
                    item
                    .code]?.item_social_icon);
                editModal.find("input[name=" + item.code + "_item_link_edit]").val(oldData
                    .language[
                        item
                        .code]?.item_link);
            });
            editModal.find("input[name=image]").attr("data-preview-name", oldData.image);
            fileHolderPreviewReInit("#footer-edit input[name=image]");
            openModalBySelector("#footer-edit");

        });

        $(".delete-modal-button").click(function() {
            var oldData = JSON.parse($(this).parents("tr").attr("data-item"));

            var actionRoute = "{{ setRoute('admin.setup.sections.section.item.delete', $slug) }}";
            var target = oldData.id;
            var message = `Are you sure to <strong>delete</strong> item?`;

            openDeleteModal(actionRoute, target, message);
        });
    </script>
@endpush
