<div class="sidebar">
    <div class="sidebar-inner">
        <div class="sidebar-logo">
            <a href="{{ setRoute('admin.dashboard') }}" class="sidebar-main-logo">
                <img src="{{ get_logo(@$basic_settings) }}" data-white_img="{{ get_logo(@$basic_settings, 'white') }}"
                    data-dark_img="{{ get_logo(@$basic_settings, 'dark') }}" alt="logo">
            </a>
            <button class="sidebar-menu-bar">
                <i class="fas fa-exchange-alt"></i>
            </button>
        </div>
        <div class="sidebar-user-area">
            <div class="sidebar-user-thumb">
                <a href="{{ setRoute('admin.profile.index') }}"><img
                        src="{{ get_image(Auth::user()->image, 'admin-profile', 'profile') }}" alt="user"></a>
            </div>
            <div class="sidebar-user-content">
                <h6 class="title">{{ Auth::user()->fullname }}</h6>
                <span class="sub-title">{{ Auth::user()->getRolesString() }}</span>
            </div>
        </div>
        @php
            $current_route = Route::currentRouteName();
        @endphp
        <div class="sidebar-menu-wrapper">
            <ul class="sidebar-menu">

                @include('admin.components.side-nav.link', [
                    'route' => 'admin.dashboard',
                    'title' => 'Dashboard',
                    'icon' => 'menu-icon las la-rocket',
                ])

                {{-- Section Default --}}
                @include('admin.components.side-nav.link-group', [
                    'group_title' => 'Default',
                    'group_links' => [
                        [
                            'title' => 'Setup Currency',
                            'route' => 'admin.currency.index',
                            'icon' => 'menu-icon las la-coins',
                        ],
                        [
                            'title' => 'Fees & Charges',
                            'route' => 'admin.trx.settings.index',
                            'icon' => 'menu-icon las la-wallet',
                        ],
                    ],
                ])


                <li class="sidebar-menu-item @if (URL::current() == setRoute('admin.service.area.index')) active @endif">
                    <a href="{{ setRoute('admin.service.area.index') }}">
                        <i class="menu-icon las la-map-marker-alt"></i>
                        <span class="menu-title">{{ __('Setup Service Area') }}</span>
                    </a>
                </li>
                <li class="sidebar-menu-header">{{ __('Contact') }}</li>
                <li class="sidebar-menu-item @if (URL::current() == setRoute('admin.subscribers')) active @endif">
                    <a href="{{ route('admin.subscribers') }}">
                        <i class="menu-icon las la-envelope"></i>
                        <span class="menu-title">{{ __('Subscriber List') }}</span>
                    </a>
                </li>
                <li class="sidebar-menu-item @if (URL::current() == setRoute('admin.contacts.index')) active @endif">
                    <a href="{{ route('admin.contacts.index') }}">
                        <i class="menu-icon las la-comment-dots"></i>

                        <span class="menu-title">{{ __('Contact List') }}</span>
                    </a>
                </li>

                {{-- Section Transaction & Logs --}}
                @include('admin.components.side-nav.link-group', [
                    'group_title' => 'Transactions & Logs',
                    'group_links' => [
                        'dropdown' => [
                            [
                                'title' => 'Money Out Logs',
                                'icon' => 'menu-icon las la-calculator',
                                'links' => [
                                    [
                                        'title' => 'Review Payment Logs',
                                        'route' => 'admin.money.out.review.payment',
                                    ],
                                    [
                                        'title' => 'Pending Logs',
                                        'route' => 'admin.money.out.pending',
                                    ],
                                    [
                                        'title' => 'Confirm Payment Logs',
                                        'route' => 'admin.money.out.confirm.payment',
                                    ],
                                    [
                                        'title' => 'On Hold Logs',
                                        'route' => 'admin.money.out.onhold',
                                    ],
                                    [
                                        'title' => 'Settled Logs',
                                        'route' => 'admin.money.out.settled',
                                    ],
                                    [
                                        'title' => 'Completed Logs',
                                        'route' => 'admin.money.out.completed',
                                    ],
                                    [
                                        'title' => 'Canceled Logs',
                                        'route' => 'admin.money.out.canceled',
                                    ],
                                    [
                                        'title' => 'Failed Logs',
                                        'route' => 'admin.money.out.failed',
                                    ],
                                    [
                                        'title' => 'Refunded Logs',
                                        'route' => 'admin.money.out.refunded',
                                    ],
                                    [
                                        'title' => 'Delayed Logs',
                                        'route' => 'admin.money.out.delayed',
                                    ],
                                    [
                                        'title' => 'All Logs',
                                        'route' => 'admin.money.out.index',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ])

                {{-- Interface Panel --}}
                @include('admin.components.side-nav.link-group', [
                    'group_title' => 'Interface Panel',
                    'group_links' => [
                        'dropdown' => [
                            [
                                'title' => 'User Care',
                                'icon' => 'menu-icon las la-user-edit',
                                'links' => [
                                    [
                                        'title' => 'Active Users',
                                        'route' => 'admin.users.active',
                                    ],
                                    [
                                        'title' => 'Email Unverified',
                                        'route' => 'admin.users.email.unverified',
                                    ],

                                    [
                                        'title' => 'All Users',
                                        'route' => 'admin.users.index',
                                    ],
                                    [
                                        'title' => 'Email To Users',
                                        'route' => 'admin.users.email.users',
                                    ],
                                    [
                                        'title' => 'Banned Users',
                                        'route' => 'admin.users.banned',
                                    ],
                                ],
                            ],
                            [
                                'title' => 'Nanny Care',
                                'icon' => 'menu-icon las la-user-edit',
                                'links' => [
                                    [
                                        'title' => 'Active Nannies',
                                        'route' => 'admin.nannies.active',
                                    ],
                                    [
                                        'title' => 'Email Unverified',
                                        'route' => 'admin.nannies.email.unverified',
                                    ],
                                    [
                                        'title' => 'KYC Unverified',
                                        'route' => 'admin.nannies.kyc.unverified',
                                    ],
                                    [
                                        'title' => 'All Nannies',
                                        'route' => 'admin.nannies.index',
                                    ],
                                    [
                                        'title' => 'Email To Nannies',
                                        'route' => 'admin.nannies.email.users',
                                    ],
                                    [
                                        'title' => 'Banned Nannies',
                                        'route' => 'admin.nannies.banned',
                                    ],
                                ],
                            ],
                            [
                                'title' => 'Admin Care',
                                'icon' => 'menu-icon las la-user-shield',
                                'links' => [
                                    [
                                        'title' => 'All Admin',
                                        'route' => 'admin.admins.index',
                                    ],
                                    [
                                        'title' => 'Admin Role',
                                        'route' => 'admin.admins.role.index',
                                    ],
                                    [
                                        'title' => 'Role Permission',
                                        'route' => 'admin.admins.role.permission.index',
                                    ],
                                    [
                                        'title' => 'Email To Admin',
                                        'route' => 'admin.admins.email.admins',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ])

                {{-- Section Settings --}}
                @include('admin.components.side-nav.link-group', [
                    'group_title' => 'Settings',
                    'group_links' => [
                        'dropdown' => [
                            [
                                'title' => 'Web Settings',
                                'icon' => 'menu-icon lab la-safari',
                                'links' => [
                                    [
                                        'title' => 'Basic Settings',
                                        'route' => 'admin.web.settings.basic.settings',
                                    ],
                                    [
                                        'title' => 'Image Assets',
                                        'route' => 'admin.web.settings.image.assets',
                                    ],
                                    [
                                        'title' => 'Setup SEO',
                                        'route' => 'admin.web.settings.setup.seo',
                                    ],
                                ],
                            ],
                            [
                                'title' => 'App Settings',
                                'icon' => 'menu-icon las la-mobile',
                                'links' => [
                                    [
                                        'title' => 'Splash Screen',
                                        'route' => 'admin.app.settings.splash.screen',
                                    ],
                                    [
                                        'title' => 'Onboard Screen',
                                        'route' => 'admin.app.settings.onboard.screens',
                                    ],
                                    [
                                        'title' => 'App URLs',
                                        'route' => 'admin.app.settings.urls',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ])

                @include('admin.components.side-nav.link', [
                    'route' => 'admin.languages.index',
                    'title' => 'Languages',
                    'icon' => 'menu-icon las la-language',
                ])
                @include('admin.components.side-nav.link',[
                    'route'     => 'admin.system.maintenance.index',
                    'title'     => "System Maintenance",
                    'icon'      => "menu-icon las la-tools",
                ])

                {{-- Verification Center --}}
                @include('admin.components.side-nav.link-group', [
                    'group_title' => 'Verification Center',
                    'group_links' => [
                        'dropdown' => [
                            [
                                'title' => 'Setup Email',
                                'icon' => 'menu-icon las la-envelope-open-text',
                                'links' => [
                                    [
                                        'title' => 'Email Method',
                                        'route' => 'admin.setup.email.config',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ])
                @include('admin.components.side-nav.link', [
                    'route' => 'admin.setup.kyc.index',
                    'title' => 'Setup KYC',
                    'icon' => 'menu-icon las la-clipboard-list',
                ])

                @if (admin_permission_by_name('admin.setup.sections.section'))
                    <li class="sidebar-menu-header">{{ __('Setup Web Content') }}</li>
                    @php
                        $current_url = URL::current();

                        $setup_section_childs = [setRoute('admin.setup.sections.section', 'call-to-action'), setRoute('admin.setup.sections.section', 'app-download'), setRoute('admin.setup.sections.section', 'user-register'), setRoute('admin.setup.sections.section', 'login'), setRoute('admin.setup.sections.section', 'banner'), setRoute('admin.setup.sections.section', 'blog'), setRoute('admin.setup.sections.section', 'about'), setRoute('admin.setup.sections.section', 'feature'), setRoute('admin.setup.sections.section', 'best-care'), setRoute('admin.setup.sections.section', 'why-choose-us'), setRoute('admin.setup.sections.section', 'footer'), setRoute('admin.setup.sections.section', 'contact')];
                    @endphp

                    <li class="sidebar-menu-item sidebar-dropdown @if (in_array($current_url, $setup_section_childs)) active @endif">
                        <a href="javascript:void(0)">
                            <i class="menu-icon las la-terminal"></i>
                            <span class="menu-title">{{ __('Setup Section') }}</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li class="sidebar-menu-item">
                                <a href="{{ setRoute('admin.setup.sections.section', 'banner') }}"
                                    class="nav-link @if ($current_url == setRoute('admin.setup.sections.section', 'banner')) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{ __('Banner') }}</span>
                                </a>
                                <a href="{{ setRoute('admin.setup.sections.section', 'about') }}"
                                    class="nav-link @if ($current_url == setRoute('admin.setup.sections.section', 'about')) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{ __('About') }}</span>
                                </a>
                                <a href="{{ setRoute('admin.setup.sections.section', 'feature') }}"
                                    class="nav-link @if ($current_url == setRoute('admin.setup.sections.section', 'feature')) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{ __('Services') }}</span>
                                </a>
                                <a href="{{ setRoute('admin.setup.sections.section', 'best-care') }}"
                                    class="nav-link @if ($current_url == setRoute('admin.setup.sections.section', 'best-care')) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{ __('Best Care') }}</span>
                                </a>
                                <a href="{{ setRoute('admin.setup.sections.section', 'why-choose-us') }}"
                                    class="nav-link @if ($current_url == setRoute('admin.setup.sections.section', 'why-choose-us')) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{ __('Why Choose Us') }}</span>
                                </a>
                                <a href="{{ setRoute('admin.setup.sections.section', 'call-to-action') }}"
                                    class="nav-link @if ($current_url == setRoute('admin.setup.sections.section', 'call-to-action')) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{ __('Call To Action') }}</span>
                                </a>
                                <a href="{{ setRoute('admin.setup.sections.section', 'app-download') }}"
                                    class="nav-link @if ($current_url == setRoute('admin.setup.sections.section', 'app-download')) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{ __('App Download') }}</span>
                                </a>
                                <a href="{{ setRoute('admin.setup.sections.section', 'blog') }}"
                                    class="nav-link @if ($current_url == setRoute('admin.setup.sections.section', 'blog')) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{ __('Blog') }}</span>
                                </a>
                                <a href="{{ setRoute('admin.setup.sections.section', 'footer') }}"
                                    class="nav-link @if ($current_url == setRoute('admin.setup.sections.section', 'footer')) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{ __('Footer') }}</span>
                                </a>
                                <a href="{{ setRoute('admin.setup.sections.section', 'contact') }}"
                                    class="nav-link @if ($current_url == setRoute('admin.setup.sections.section', 'contact')) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{ __('Contact') }}</span>
                                </a>
                                <a href="{{ setRoute('admin.setup.sections.section', 'login') }}"
                                    class="nav-link @if ($current_url == setRoute('admin.setup.sections.section', 'login')) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{ __('Login') }}</span>
                                </a>
                                <a href="{{ setRoute('admin.setup.sections.section', 'user-register') }}"
                                    class="nav-link @if ($current_url == setRoute('admin.setup.sections.section', 'user-register')) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{ __('User Register') }}</span>
                                </a>

                            </li>
                        </ul>
                    </li>
                @endif

                @include('admin.components.side-nav.link', [
                    'route' => 'admin.extensions.index',
                    'title' => 'Extensions',
                    'icon' => 'menu-icon las la-puzzle-piece',
                ])
                @if (admin_permission_by_name('admin.payment.gateway.view'))
                    <li class="sidebar-menu-header">{{ __('Payment Methods') }}</li>
                    @php
                        $payment_add_money_childs = [setRoute('admin.payment.gateway.view', ['add-money', 'automatic']), setRoute('admin.payment.gateway.view', ['add-money', 'manual'])];
                    @endphp
                    <li class="sidebar-menu-item sidebar-dropdown @if (in_array($current_url, $payment_add_money_childs)) active @endif">
                        <a href="javascript:void(0)">
                            <i class="menu-icon las la-funnel-dollar"></i>
                            <span class="menu-title">{{ __('Setup Gateway') }}</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li class="sidebar-menu-item">
                                <a href="{{ setRoute('admin.payment.gateway.view', ['add-money', 'automatic']) }}"
                                    class="nav-link @if ($current_url == setRoute('admin.payment.gateway.view', ['add-money', 'automatic'])) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{ __('Automatic') }}</span>
                                </a>
                                <a href="{{ setRoute('admin.payment.gateway.view', ['add-money', 'manual']) }}"
                                    class="nav-link @if ($current_url == setRoute('admin.payment.gateway.view', ['add-money', 'manual'])) active @endif">
                                    <i class="menu-icon las la-ellipsis-h"></i>
                                    <span class="menu-title">{{ __('Money Out') }}</span>
                                </a>

                            </li>
                        </ul>
                    </li>
                @endif

                <li class="sidebar-menu-header">{{ __('Generale') }}</li>
                @include('admin.components.side-nav.link', [
                    'route' => 'admin.useful.links.index',
                    'title' => 'Useful Links',
                    'icon' => 'menu-icon las la-link',
                ])

                {{-- Notifications --}}
                @include('admin.components.side-nav.link-group', [
                    'group_title' => 'Notification',
                    'group_links' => [
                        'dropdown' => [
                            [
                                'title' => 'Push Notification',
                                'icon' => 'menu-icon las la-bell',
                                'links' => [
                                    [
                                        'title' => 'Setup Notification',
                                        'route' => 'admin.push.notification.config',
                                    ],
                                    [
                                        'title' => 'Send Notification',
                                        'route' => 'admin.push.notification.index',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ])

                @php
                    $bonus_routes = ['admin.cookie.index', 'admin.server.info.index', 'admin.cache.clear'];
                @endphp

                @if (admin_permission_by_name_array($bonus_routes))
                    <li class="sidebar-menu-header">{{ __('Bonus') }}</li>
                @endif

                @include('admin.components.side-nav.link', [
                    'route' => 'admin.cookie.index',
                    'title' => 'GDPR Cookie',
                    'icon' => 'menu-icon las la-cookie-bite',
                ])

                @include('admin.components.side-nav.link', [
                    'route' => 'admin.server.info.index',
                    'title' => 'Server Info',
                    'icon' => 'menu-icon las la-sitemap',
                ])

                @include('admin.components.side-nav.link', [
                    'route' => 'admin.cache.clear',
                    'title' => 'Clear Cache',
                    'icon' => 'menu-icon las la-broom',
                ])
            </ul>
        </div>
    </div>
</div>
