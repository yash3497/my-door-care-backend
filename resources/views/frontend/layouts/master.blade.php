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
    <meta name="keywords" content="{{ @$tag ?? '' }}">
    <meta name="title" content="{{ @$setup_seo->title }}" />
    <meta name="description" content="{{ @$setup_seo->desc }}" />
    <title>{{ @$basic_settings->site_name }} | {{ @$basic_settings->site_title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    @include('partials.header-asset')
    @stack('css')
</head>

<body class="{{ selectedLangDir() ?? 'ltr' }}">

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start body overlay
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <div id="body-overlay" class="body-overlay"></div>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End body overlay
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start Scroll-To-Top Section
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <button type="button" id="btn-back-to-top">
        <i class="fas fa-arrow-up scroll-top"></i>
    </button>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End Scroll-To-Top Section
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Start Preloader~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <div class="preloader">
        <div class="loader-inner">
            <div class="loader-circle"> <img src="{{ get_fav($basic_settings, 'white') }}" alt="Preloader"> </div>
            <div class="loader-line-mask">
                <div class="loader-line"></div>
            </div>
        </div>
    </div><!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ End Preloader~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start Header
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    @include('frontend.partials.header')
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End Header
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

    @yield('content')


    @include('frontend.partials.talk-to-expert')
    @include('frontend.partials.footer')

    @include('partials.footer-asset')
    @include('admin.partials.notify')
    @stack('script')
</body>

</html>
