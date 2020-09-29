<!doctype html>
<html lang="ar">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
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


<header class="bg-dark pt-9 pb-11 d-md-block" style="text-align: right">
    <div class="container-md">
        <div class="row align-items-center">
            <div class="col">
            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</header>


<main class="pb-8 pb-md-11 mt-md-n6  pb-sm-11 mt-sm-n6" style="direction: rtl; text-align: right; margin-top: -100px !important;">
    <div class="container-md">
        <div class="row">
            <div class="col-12 col-md-12">

                <!-- Card -->
                <div class="card card-bleed shadow-light-lg">
                    <div class="card-header">

                        <!-- Heading -->
                        <h4 class="mb-0">
                            تنبية*
                        </h4>

                    </div>
                    <div class="card-body">
                       {{ $message }}
                    </div>
                </div>

            </div>

        </div> <!-- / .row -->
    </div> <!-- / .container -->
</main>



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
</body>
</html>
