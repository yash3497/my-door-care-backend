@php
    $current_route = Route::currentRouteName();

@endphp
<header class="header-section">
    <div class="header">
        <div class="header-bottom-area">
            <div class="container">
                <div class="header-menu-content">
                    <nav class="navbar navbar-expand-lg p-0">
                        <a class="site-logo site-title" href="{{ route('index') }}"><img
                                src="{{ get_logo($basic_settings) }}" alt="site-logo"></a>
                        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fas fa-bars"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav main-menu me-auto ps-0 ps-xl-5 ps-lg-5">
                                <li><a href="{{ route('index') }}"
                                        class="{{ $current_route == 'index' ? 'active' : '' }}">{{ __('Home') }}</a>
                                </li>
                                <li><a href="{{ route('about') }}"
                                        class="{{ $current_route == 'about' ? 'active' : '' }}">{{ __('About Us') }}</a>
                                </li>
                                <li><a href="{{ route('services') }}"
                                        class="{{ $current_route == 'services' ? 'active' : '' }}">{{ __('Services') }}</a>
                                </li>
                                <li><a href="{{ route('blog') }}"
                                        class="{{ $current_route == 'blog' ? 'active' : '' }}">{{ __('Blog') }}</a>
                                </li>
                                <li><a href="{{ route('contact') }}"
                                        class="{{ $current_route == 'contact' ? 'active' : '' }}">{{ __('Contact Us') }}</a>
                                </li>
                            </ul>
                            <div class="lan-swicth">
                                @php
                                    $session_lan = session('local') ?? get_default_language_code();

                                @endphp
                                <select class="langSel nice-select">
                                    @foreach ($__languages as $item)
                                        <option value="{{ $item->code }}"
                                            @if ($session_lan == $item->code) selected @endif>{{ __($item->name) }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="header-action ms-lg-3 ms-0">

                                @if (auth()->guard('web')->check() &&
                                        auth()->guard('web')->user()->email_verified == 1)
                                    <a href="{{ route('user.dashboard') }}"
                                        class="btn--base">{{ __('Dashboard') }}</a>
                                @elseif (auth()->guard('nanny')->check() &&
                                        auth()->guard('nanny')->user()->email_verified == 1)
                                    <a href="{{ route('nanny.dashboard') }}"
                                        class="btn--base">{{ __('Dashboard') }}</a>
                                @else
                                    <a href="{{ route('user.login') }}" class="btn--base">{{ __('Login Now') }}</a>
                                @endif
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
