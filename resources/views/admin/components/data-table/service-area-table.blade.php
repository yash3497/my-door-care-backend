<table class="custom-table admin-search-table">
    <thead>
        <tr>
            <th>{{__('Service Area')}}</th>
            <th>{{__('Slug')}}</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($service_areas ?? [] as $item)
            <tr data-item="{{ $item }}">
                <td>{{ $item->service_area }}</td>
                <td>{{ $item->slug }} </td>

                <td>
                    @include('admin.components.link.edit-default', [
                        'class' => 'edit-modal-button',
                        'permission' => 'admin.service.area.update',
                    ])
                    @include('admin.components.link.delete-default', [
                        'class' => 'delete-modal-button',
                        'permission' => 'admin.admins.admin.delete',
                    ])

                </td>
            </tr>
        @empty
            @include('admin.components.alerts.empty', ['colspan' => 8])
        @endforelse
    </tbody>
</table>
