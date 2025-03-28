@php
    $current_route = Route::currentRouteName();
    
    $current_url = URL::current();
    
    $all_routes = [route('user.dashboard'), route('user.add.baby.pet.index'), route('user.nanny.list.index'), route('user.support.ticket.index'), route('user.security.google.2fa'), route('user.profile.password.change.form'), route('user.profile.index')];
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
                    <li class="sidebar-menu-item {{ $current_route == 'user.dashboard' ? 'active' : '' }}">
                        <a href="{{ route('user.dashboard') }}">
                            <i class="menu-icon las la-home"></i>
                            <span class="menu-title">{{ __('Dashboard') }}</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item {{ $current_route == 'user.add.baby.pet.index' ? 'active' : '' }}">
                        <a href="{{ route('user.add.baby.pet.index') }}">
                            <i class="menu-icon las la-paw"></i>
                            <span class="menu-title">{{ __('My Baby / Pets') }}</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item {{ $current_route == 'user.nanny.list.index' ? 'active' : '' }}">
                        <a href="{{ route('user.nanny.list.index') }}">
                            <i class="menu-icon las la-users"></i>
                            <span class="menu-title">{{ __('Nanny List') }}</span>
                        </a>
                    </li>
                    <li
                        class="sidebar-menu-item {{ $current_route == 'user.service.tracking.index' ? 'active' : '' }}">
                        <a href="{{ route('user.service.tracking.index') }}">
                            <i class="menu-icon las la-route"></i>
                            <span class="menu-title">{{ __('Service Tracking') }}</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item {{ $current_route == 'user.support.ticket.index' ? 'active' : '' }}">
                        <a href="{{ route('user.support.ticket.index') }}">
                            <i class="menu-icon las la-question-circle"></i>
                            <span class="menu-title">{{ __('Support') }}</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item {{ $current_route == 'user.security.google.2fa' ? 'active' : '' }}">
                        <a href="{{ route('user.security.google.2fa') }}">
                            <i class="menu-icon las la-shield-alt"></i>
                            <span class="menu-title">{{ __('2FA Security') }}</span>
                        </a>
                    </li>
                    <li
                        class="sidebar-menu-item {{ $current_route == 'user.profile.password.change.form' ? 'active' : '' }}">
                        <a href="{{ route('user.profile.password.change.form') }}">
                            <i class="menu-icon las la-key"></i>
                            <span class="menu-title">{{ __('Change Password') }}</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item {{ $current_route == 'user.profile.index' ? 'active' : '' }}">
                        <a href="{{ route('user.profile.index') }}">
                            <i class="menu-icon las la-user-circle"></i>
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
                <p>{{ __('Copyright') }} © {{ date('Y') }} <a href="#0">{{ $basic_settings->site_name }}</a>
                </p>
            </div>
        </div>
    </div>
</div>
