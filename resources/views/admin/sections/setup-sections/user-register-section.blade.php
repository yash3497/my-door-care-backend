@php
    $default_lang_code = language_const()::NOT_REMOVABLE;
    $system_default_lang = get_default_language_code();
    $languages_for_js_use = $languages->toJson();
@endphp

@extends('admin.layouts.master')

@push('css')
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
        'active' => __('Register Section'),
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
                    <div class="col-xl-4 col-lg-4 form-group">
                        @include('admin.components.form.input-file', [
                            'label' => 'Image:',
                            'name' => 'image',
                            'class' => 'file-holder',
                            'old_files_path' => files_asset_path('site-section'),
                            'old_files' => $data->value->image ?? '',
                        ])
                    </div>
                    <div class="col-xl-8 col-lg-8">
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
                                        @include('admin.components.form.input', [
                                            'label' => 'Heading*',
                                            'name' => $default_lang_code . '_heading',
                                            'value' => old(
                                                $default_lang_code . '_heading',
                                                $data->value->language->$default_lang_code->heading ?? ''),
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
                                            @include('admin.components.form.input', [
                                                'label' => 'Heading*',
                                                'name' => $item->code . '_heading',
                                                'value' => old(
                                                    $item->code . '_heading',
                                                    $data->value->language->$lang_code->heading ?? ''),
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
@endsection

@push('script')
    <script>
        var default_language = "{{ $default_lang_code }}";
        var system_default_language = "{{ $system_default_lang }}";
        var languages = "{{ $languages_for_js_use }}";
        languages = JSON.parse(languages.replace(/&quot;/g, '"'));
    </script>
@endpush
