@php
    $menues = DB::table('setup_pages')
        ->where('status', 1)
        ->get();
@endphp
<div class="main-side-menu">
    <div class="main-side-menu-logo-area">
        <div class="thumb-logo">
            <img src="{{ get_logo($basic_settings, 'dark') }}" alt="logo">
        </div>
        <span class="main-side-menu-cross"><i class="las la-times"></i></span>
    </div>
    <ul class="main-side-menu-list">


        @php
            $current_url = URL::current();
        @endphp
        @foreach ($menues as $item)
            @php
                $title = json_decode($item->title);
            @endphp
            <li>
                <a href="{{ url($item->url) }}" class="@if ($current_url == url($item->url)) active @endif
            ">
                    <div class="main-side-menu-item">
                        <i class="las la-th-large"></i> {{ $item->title }}
                    </div>
                    <span><i class="las la-angle-right"></i></span>
                </a>
            </li>
        @endforeach
        
    </ul>
</div>
