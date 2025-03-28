<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @php
        if ($setup_seo->tags) {
            $tag = implode(', ', $setup_seo->tags);
        }
    @endphp
    <meta name="keywords" content="{{ $tag ?? '' }}">
    <meta name="title" content="{{ $setup_seo->title }}" />
    <meta name="description" content="{{ $setup_seo->desc }}" />
    <title>{{ $basic_settings->site_name }} | {{ $basic_settings->site_title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    @include('partials.header-asset')
    @stack('css')
</head>

<body class="{{ selectedLangDir() ?? 'ltr' }}">


    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start Scroll-To-Top Section
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <button type="button" id="btn-back-to-top">
        <i class="fas fa-arrow-up scroll-top"></i>
    </button>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End Scroll-To-Top Section
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->


    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start Header
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    @include('frontend.partials.header')
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End Header
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

    @yield('content')



    @include('frontend.partials.footer')

    @include('partials.footer-asset')
    @include('admin.partials.notify')
    @include('user.partials.auth-control')
    <script src="{{ asset('public/frontend/js/apexcharts.js') }}"></script>
    @stack('script')
    <!-- asos -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <!-- chosen js -->
    <script src="{{ asset('public/frontend') }}/js/chosen.jquery.js"></script>
    <script>
        AOS.init({
            duration: 1200,
        });
    </script>
    <script src="{{ asset('public/frontend') }}/js/jquery.nice-select.js"></script>
    <script>
        $("select").niceSelect()
    </script>

</body>

</html>
