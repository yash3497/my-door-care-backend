<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($page_title) ? __($page_title) : __('Dashboard') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&display=swap" rel="stylesheet">

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
        Start Page-wrapper
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <div class="page-wrapper">

        @include('user.partials.side-nav')

        <div class="main-wrapper">
            <div class="main-body-wrapper">
                <!-- top navbar-wrapper-start -->
                @include('user.partials.top-nav')
                <!-- body-wrapper-start -->
                @yield('content')
            </div>
        </div>
    </div>




    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End Page-wrapper
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->



    <!-- Modal -->
    <div class="modal fade" id="mypetsmodal" tabindex="-1" aria-labelledby="mypetsmodalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="mypetsmodalLabel">Pet Information</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="col-lg-4 modal-thumb">
                        <img src="{{ asset('public/frontend') }}/images/element/g2.jpg" class="d-flex mx-lg-0 mx-auto"
                            alt="image">
                        <h3>Cooper</h3>
                    </div>
                    <div class="col-lg-8">
                        <div class="d-flex justify-content-between item">
                            <h3>Pet Type:</h3>
                            <h3>Cat</h3>
                        </div>
                        <div class="d-flex justify-content-between item">
                            <h3>Pet Name:</h3>
                            <h3>Cooper</h3>
                        </div>
                        <div class="d-flex justify-content-between item">
                            <h3>Pet Age:</h3>
                            <h3>1-6 Month</h3>
                        </div>
                        <div class="d-flex justify-content-between item">
                            <h3>Pet Weight:</h3>
                            <h3>1-6 Month</h3>
                        </div>
                        <div class="d-flex justify-content-between item">
                            <h3>Pet Breed:</h3>
                            <h3>Greyhound</h3>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn--base btn-1">Delect</button>
                    <button type="button" class="btn--base" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    @include('partials.footer-asset')
    @include('admin.partials.notify')
    @include('user.partials.auth-control')
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
