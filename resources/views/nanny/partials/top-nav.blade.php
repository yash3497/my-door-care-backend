<nav class="navbar-wrapper">
    <div class="navbar-wrapper-area">
        <div class="dashboard-title-part d-flex">
            <div class="navbar__left my-auto">
                <button class="navbar__expand ps-0 pe-3">
                    <i class="las fa-bars"></i>
                </button>
            </div>
            <h4 class="title">{{ __('Dashboard') }}</h4>
        </div>
        <div class="navbar__right d-flex">
            <div class="header-notification-wrapper">
                <button class="notification-icon">
                    <i class="las la-bell"></i>
                </button>
                <div class="notification-wrapper">
                    <div class="notification-header">
                        <h5 class="title">{{ __('Notification') }}</h5>
                    </div>
                    <ul class="notification-list">

                        @foreach (get_nanny_notifications() as $item)
                            <li>
                                <div class="thumb">
                                    <img src="{{ auth()->user()->userImage }}" alt="user">
                                </div>
                                <div class="content">
                                    <div class="title-area">
                                        <h6 class="title">{{ __($item->message->title) }}</h6>
                                        <span class="time">{{ $item->created_at->diffForHumans() }}</span>
                                    </div>
                                    <span class="sub-title">{{ __($item->message->message) }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="navbar__right ">
                <ul class="navbar__action-list" style="list-style: none;">
                    <li class="dropdown">
                        <a href="{{ route('nanny.profile.index') }}">
                            <span class="navbar-user">
                                <span class="navbar-user__thumb"><img src="{{ auth()->user()->userImage }}"
                                        alt="user"></span>
                                <span class="navbar-user__info">
                                    <span class="navbar-user__name">{{ auth()->user()->fullname }}</span>
                                </span>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
</nav>
