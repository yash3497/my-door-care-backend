 <!-- fontawesome css link -->
 <link rel="stylesheet" href="{{ asset('public/frontend') }}/css/fontawesome-all.css">
 <!-- bootstrap css link -->
 <link rel="stylesheet" href="{{ asset('public/frontend') }}/css/bootstrap.css">
 <!-- favicon -->
 <link rel="shortcut icon" href="{{ get_fav($basic_settings, 'white') }}" type="image/x-icon">
 <!-- swipper css link -->
 <link rel="stylesheet" href="{{ asset('public/frontend') }}/css/swiper.css">
 <!-- lightcase css links -->
 <link rel="stylesheet" href="{{ asset('public/frontend') }}/css/lightcase.css">
 <!-- line-awesome-icon css -->
 <link rel="stylesheet" href="{{ asset('public/frontend') }}/css/line-awesome.css">
 <!-- animate.css -->
 <link rel="stylesheet" href="{{ asset('public/frontend') }}/css/animate.css">
 <!-- odometer -->
 <link rel="stylesheet" href="{{ asset('public/frontend') }}/css/odometer.css">
 <!-- main style css link -->
 <link rel="stylesheet" href="{{ asset('public/frontend') }}/css/style.css">
 <!-- Popup  -->
 <link rel="stylesheet" href="{{ asset('public/backend/library/popup/magnific-popup.css') }}">
<!-- Fileholder CSS CDN -->
<link rel="stylesheet" href="https://appdevs.cloud/cdn/fileholder/v1.0/css/fileholder-style.css" type="text/css">

 <!-- chosen CSS -->
 <link rel="stylesheet" href="{{ asset('public/frontend') }}/css/chosen.css">
 <!-- Asos CSS -->
 <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
 <!-- nice-select -->
 <link rel="stylesheet" href="{{ asset('public/frontend') }}/css/nice-select.css">


 @php
     $base_color = $basic_settings->base_color;
 @endphp

 {{-- Dynamic Color From Admin --}}
 <style>
     :root {
         --base_color: {{ $base_color }};
     }

     .select2-container--default .select2-selection--single .select2-selection__rendered {
         color: #ffffff;
     }
 </style>
