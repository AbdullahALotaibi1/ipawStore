<!doctype html>
<html lang="ar">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Libs CSS -->
    <link rel="stylesheet" href="{{ asset('assets/welcome/fonts/Feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/welcome/libs/flickity/dist/flickity.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/welcome/libs/flickity-fade/flickity-fade.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/welcome/libs/aos/dist/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/welcome/libs/jarallax/dist/jarallax.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/welcome/libs/highlightjs/styles/vs2015.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/welcome/libs/%40fancyapps/fancybox/dist/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/welcome/fonts/fontawesome/css/all.min.css') }}">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/welcome/css/theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/welcome/css/theme-rtl.css') }}">

    <title>{{ \App\Setting::all()->first()->title }}</title>
</head>
<body>

<!-- NAVBAR
   ================================================== -->
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">

        <!-- Brand -->
        <a class="navbar-brand text-primary-desat" >
            <img src="{{ asset('storage/images/logo/'. \App\Setting::all()->first()->logo_store.'') }}" style="width: 50px; height: 50px; border-radius: 7px;">
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="navbarCollapse">

            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fe fe-x"></i>
            </button>

            <!-- Navigation -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ \Illuminate\Support\Facades\URL::to('/storage/mobileconfig/download.mobileconfig') }}">
                        تحميل المتجر
                    </a>
                </li>

            </ul>
        </div>

    </div>
</nav>

@yield('content')

<!-- JAVASCRIPT
   ================================================== -->
<!-- Libs JS -->
<script src="{{ asset('assets/welcome/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/welcome/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/welcome/libs/flickity/dist/flickity.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/welcome/libs/flickity-fade/flickity-fade.js') }}"></script>
<script src="{{ asset('assets/welcome/libs/aos/dist/aos.js') }}"></script>
<script src="{{ asset('assets/welcome/libs/smooth-scroll/dist/smooth-scroll.min.js') }}"></script>
<script src="{{ asset('assets/welcome/libs/jarallax/dist/jarallax.min.js') }}"></script>
<script src="{{ asset('assets/welcome/libs/jarallax/dist/jarallax-video.min.js') }}"></script>
<script src="{{ asset('assets/welcome/libs/jarallax/dist/jarallax-element.min.js') }}"></script>
<script src="{{ asset('assets/welcome/libs/typed.js/lib/typed.min.js') }}"></script>
<script src="{{ asset('assets/welcome/libs/countup.js/dist/countUp.min.js') }}"></script>
<script src="{{ asset('assets/welcome/libs/highlightjs/highlight.pack.min.js') }}"></script>
<script src="{{ asset('assets/welcome/libs/%40fancyapps/fancybox/dist/jquery.fancybox.min.js') }}"></script>
<script src="{{ asset('assets/welcome/libs/isotope-layout/dist/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/welcome/libs/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/welcome/fonts/fontawesome/js/all.min.js') }}"></script>

<!-- Theme JS -->
<script src="{{ asset('assets/welcome/js/theme.min.js') }}"></script>
@yield('javascript')
</body>
</html>
