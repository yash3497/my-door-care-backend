@php
    $current_route = Route::currentRouteName();
    $current_url = URL::current();
    $transaction_childs = [route('user.transactions.buy.coin.index'), route('user.transactions.index', 'add-money'), route('user.transactions.index', 'money-out'), route('user.transactions.index', 'sell-coin'), route('user.transactions.index', 'withdraw')];
    $unseen_user_request_count = App\Models\UserRequest::where('nanny_id', auth()->user()->id)
        ->where('seen_status', 'unseen')
        ->count();

@endphp
<div class="sidebar">
    <div class="sidebar__inner">
        <div class="sidebar-top-inner">
            <div class="sidebar__logo">
                <a href="{{ route('index') }}" class="sidebar__main-logo">
                    <img src="{{ get_logo($basic_settings, 'white') }}" alt="logo">
                </a>
                <div class="navbar__left">
                    <button class="sidebar-mobile-menu text-white">
                        <i class="las fa-bars"></i>
                    </button>
                </div>
            </div>
            <div class="sidebar__menu-wrapper">
                <ul class="sidebar__menu p-0">
                    <li class="sidebar-menu-item {{ $current_route == 'nanny.dashboard' ? 'active' : '' }}">
                        <a href="{{ route('nanny.dashboard') }}">
                            <i class="menu-icon las la-home"></i>
                            <span class="menu-title">{{ __('Dashboard') }}</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item {{ $current_route == 'nanny.service.request.index' ? 'active' : '' }}">
                        <a href="{{ route('nanny.service.request.index') }}">
                            <i class="menu-icon las la-paw"></i>
                            <span class="menu-title">{{ __('Service Request') }}</span>
                            <div class="sidebar-item-badge"> <span class="badge unseen_count"
                                    class="badge">{{ $unseen_user_request_count == 0 ? '0' : $unseen_user_request_count }}</span>
                            </div>
                        </a>
                    </li>
                    <li class="sidebar-menu-item @if ($current_route == 'user.withdraw.index') active @endif">
                        <a href="{{ route('nanny.withdraw.index') }}">
                            <i class="menu-icon las la-receipt"></i>
                            <span class="menu-title">{{ __('Money Out') }}</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item {{ $current_route == 'nanny.profile.kyc' ? 'active' : '' }}">
                        <a href="{{ route('nanny.profile.kyc') }}">
                            <i class="menu-icon las la-shield-alt"></i>
                            <span class="menu-title">{{ __('KYC') }}</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item {{ $current_route == 'nanny.support.ticket.index' ? 'active' : '' }}">
                        <a href="{{ route('nanny.support.ticket.index') }}">
                            <i class="menu-icon las la-question-circle"></i>
                            <span class="menu-title">{{ __('Support') }}</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item {{ $current_route == 'nanny.security.google.2fa' ? 'active' : '' }}">
                        <a href="{{ route('nanny.security.google.2fa') }}">
                            <i class="menu-icon las la-shield-alt"></i>
                            <span class="menu-title">{{ __('2FA Security') }}</span>
                        </a>
                    </li>
                    <li
                        class="sidebar-menu-item {{ $current_route == 'nanny.profile.password.change.form' ? 'active' : '' }}">
                        <a href="{{ route('nanny.profile.password.change.form') }}">
                            <i class="menu-icon las la-key"></i>
                            <span class="menu-title">{{ __('Change Password') }}</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item {{ $current_route == 'nanny.profile.index' ? 'active' : '' }}">
                        <a href="{{ route('nanny.profile.index') }}">
                            <i class="menu-icon las la-user"></i>
                            <span class="menu-title">{{ __('Profile') }}</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="" class="logout-btn">
                            <i class="menu-icon las la-sign-out-alt"></i>
                            <span class="menu-title">{{ __('Logout') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="copyright-wrapper">

            <div class="copyright-area">
                <p>{{ __('Copyright') }} © {{ date('Y') }} <a
                        href="{{ route('index') }}">{{ __($basic_settings->site_name) }}</a></p>
            </div>
        </div>
    </div>
</div>
