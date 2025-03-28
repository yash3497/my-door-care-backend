<table class="custom-table user-search-table">
    <thead>
        <tr>
            <th></th>
            <th>{{__('Username')}}</th>
            <th>{{__('Email')}}</th>
            <th>{{__('Phone')}}</th>
            <th>{{__('Status')}}</th>
            <th>{{__('Action')}}</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users ?? [] as $key => $item)
            <tr>
                <td>
                    <ul class="user-list">
                        <li><img src="{{ $item->userImage }}" alt="user"></li>
                    </ul>
                </td>
                <td><span>{{ @$item->username }}</span></td>
                <td>{{ @$item->email }}</td>
                <td>{{ @$item->mobile }}</td>
                <td>
                    @if (Route::currentRouteName() == 'admin.users.kyc.unverified')
                        <span class="{{ $item->kycStringStatus->class }}">{{ $item->kycStringStatus->value }}</span>
                    @else
                        <span class="{{ $item->stringStatus->class }}">{{ $item->stringStatus->value }}</span>
                    @endif
                </td>
                <td>
                    @if (Route::currentRouteName() == 'admin.users.kyc.unverified')
                        @include('admin.components.link.info-default', [
                            'href' => setRoute('admin.users.kyc.details', $item->username),
                            'permission' => 'admin.users.kyc.details',
                        ])
                    @else
                        @include('admin.components.link.info-default', [
                            'href' => setRoute('admin.users.details', $item->username),
                            'permission' => 'admin.users.details',
                        ])
                    @endif
                </td>
            </tr>
        @empty
            @include('admin.components.alerts.empty', ['colspan' => 7])
        @endforelse
    </tbody>
</table>
