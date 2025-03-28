<table class="custom-table currency-search-table">
    <thead>
        <tr>
            <th></th>
            <th>{{__('Name | Code')}}</th>
            <th>{{__('Symbol')}}</th>
            <th>{{__('Type')}}</th>

            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($currencies ?? [] as $item)
            <tr data-item="{{ $item->editData }}">
                <td>
                    <ul class="user-list">
                        <li><img src="{{ get_image($item->flag, 'currency-flag') }}" alt="flag"></li>
                    </ul>
                </td>
                <td>{{ $item->name }}
                    @if ($item->default)
                        <span class="badge badge--success ms-1">{{ __('Default') }}</span>
                    @endif
                    <br> <span>{{ $item->code }}</span>
                </td>
                <td>{{ $item->symbol }}</td>
                <td>
                    <span class="text--info">{{ $item->type }}</span>
                    
                </td>

                <td>
                    @include('admin.components.link.edit-default', [
                        'href' => 'javascript:void(0)',
                        'class' => 'edit-modal-button',
                        'permission' => 'admin.currency.update',
                    ])
                    @if (!$item->isDefault())
                        @include('admin.components.link.delete-default', [
                            'href' => 'javascript:void(0)',
                            'class' => 'delete-modal-button',
                            'permission' => 'admin.currency.delete',
                        ])
                    @endif
                </td>
            </tr>
        @empty
            @include('admin.components.alerts.empty', ['colspan' => 7])
        @endforelse
    </tbody>
</table>

@push('script')
    <script>
        $(document).ready(function() {
            // Switcher
            switcherAjax("{{ setRoute('admin.currency.status.update') }}");
        })
    </script>
@endpush
