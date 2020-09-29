<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Libs CSS -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome/css/all.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather/feather.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/dist/flatpickr.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/quill/dist/quill.core.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/highlightjs/styles/vs2015.css')}}" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/theme.rtl.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/fonts.css') }}" />

@yield('css')

    <!-- Title -->
    <title>@yield('title') | {{ \App\Setting::all()->first()->title }}</title>

</head>
<body>

@include('dashboard.layouts.navbar')

<!-- MAIN CONTENT
    ================================================== -->
<div class="main-content">
    @yield('content')
</div>

<!-- JAVASCRIPT
================================================== -->
<!-- Libs JS -->
<script src="{{ asset('assets/fonts/fontawesome/js/all.min.js')}}"></script>
<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('assets/libs/@shopify/draggable/lib/es5/draggable.bundle.legacy.js')}}"></script>
<script src="{{ asset('assets/libs/autosize/dist/autosize.min.js')}}"></script>
<script src="{{ asset('assets/libs/chart.js/dist/Chart.min.js')}}"></script>
{{--<script src="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.js')}}"></script>--}}
<script src="{{ asset('assets/libs/flatpickr/dist/flatpickr.min.js')}}"></script>
<script src="{{ asset('assets/libs/highlightjs/highlight.pack.min.js')}}"></script>
<script src="{{ asset('assets/libs/jquery-mask-plugin/dist/jquery.mask.min.js')}}"></script>
<script src="{{ asset('assets/libs/list.js/dist/list.min.js')}}"></script>
<script src="{{ asset('assets/libs/quill/dist/quill.min.js')}}"></script>
<script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{ asset('assets/libs/chart.js/Chart.extension.js')}}"></script>

<!-- Theme JS -->
<script src="{{ asset('assets/js/theme.min.js')}}"></script>
<script src="{{ asset('assets/js/dashkit.min.js')}}"></script>

@yield('javascript')

</body>
</html>

