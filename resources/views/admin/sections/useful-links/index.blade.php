@php
    $app_local = get_default_language_code();
@endphp
@extends('admin.layouts.master')

@push('css')
    <style>
        .switch-toggles {
            margin-left: auto;
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
        'active' => __('Useful Links'),
    ])
@endsection

@section('content')
    <div class="table-area">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title">{{ __($page_title) }}</h5>
                @include('admin.components.link.add-default', [
                    'text' => 'Add Link',
                    'href' => '#link-add',
                    'class' => 'modal-btn',
                    'permission' => 'admin.useful.links.store',
                ])
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>{{__('Title')}}</th>
                            <th>{{__('Slug')}}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($useful_links ?? [] as $item)
                            <tr data-item="{{ json_encode($item->only(['id'])) }}">
                                <td>{{ $item->title->language->$app_local->title ?? '' }}</td>
                                <td>{{ $item->slug }}</td>
                                
                                <td>
                                    @include('admin.components.link.edit-default', [
                                        'href' => setRoute('admin.useful.links.edit', $item->slug),
                                        'class' => 'edit-modal-button',
                                        'permission' => 'admin.useful.links.edit',
                                    ])

                                    @if ($item->editable == true)
                                        @include('admin.components.link.delete-default', [
                                            'href' => 'javascript:void(0)',
                                            'class' => 'delete-modal-button',
                                            'permission' => 'admin.useful.links.delete',
                                        ])
                                    @endif
                                </td>
                            </tr>
                        @empty
                            @include('admin.components.alerts.empty', ['colspan' => 6])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    {{-- Add Modal --}}
    @if (admin_permission_by_name('admin.useful.links.store'))
        <div id="link-add" class="mfp-hide large">
            <div class="modal-data">
                <div class="modal-header px-0">
                    <h5 class="modal-title">{{ __('Add link') }}</h5>
                </div>
                <div class="modal-form-data">
                    <form class="modal-form" method="POST" action="{{ setRoute('admin.useful.links.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-10-none">
                            <div class="language-tab">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        @foreach ($languages as $item)
                                            <button class="nav-link @if (get_default_language_code() == $item->code) active @endif"
                                                id="modal-{{ $item->name }}-tab" data-bs-toggle="tab"
                                                data-bs-target="#modal-{{ $item->name }}" type="button" role="tab"
                                                aria-controls="modal-{{ $item->name }}"
                                                aria-selected="true">{{ $item->name }}</button>
                                        @endforeach

                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">

                                    @foreach ($languages as $item)
                                        @php
                                            $lang_code = $item->code;
                                        @endphp
                                        <div class="tab-pane @if (get_default_language_code() == $item->code) fade show active @endif"
                                            id="modal-{{ $item->name }}" role="tabpanel"
                                            aria-labelledby="modal-{{ $item->name }}-tab">
                                            <div class="form-group">
                                                @include('admin.components.form.input', [
                                                    'label' => 'Title',
                                                    'label_after' => '*',
                                                    'name' => $lang_code . '_title',
                                                    'value' => old($lang_code . '_title'),
                                                ])
                                            </div>
                                            <div class="form-group">
                                                @include('admin.components.form.input-text-rich', [
                                                    'label' => 'Content',
                                                    'label_after' => '*',
                                                    'name' => $lang_code . '_content',
                                                    'value' => old($lang_code . '_content'),
                                                ])
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 form-group">
                                @include('admin.components.form.input', [
                                    'label' => 'Slug',
                                    'label_after' => '* (Use for make page link (URL))',
                                    'name' => 'slug',
                                    'value' => old('slug'),
                                ])
                            </div>

                            <div
                                class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                                <button type="button" class="btn btn--danger modal-close">{{ __('Close') }}</button>
                                <button type="submit" class="btn btn--base">{{ __('Add') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            openModalWhenError('link-add', '#link-add');
        });

        // Switcher
        switcherAjax("{{ setRoute('admin.useful.links.status.update') }}");


        $(".delete-modal-button").click(function() {
            var oldData = JSON.parse($(this).parents("tr").attr("data-item"));

            var actionRoute = "{{ setRoute('admin.useful.links.delete') }}";
            var target = oldData.id;
            var message = `Are you sure to delete this link?`;

            openDeleteModal(actionRoute, target, message);
        });
    </script>
@endpush
