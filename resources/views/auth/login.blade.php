<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc." />

    <!-- Libs CSS -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather/feather.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/dist/flatpickr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/quill/dist/quill.core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/highlightjs/styles/vs2015.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/fonts.css') }}" />
    <!-- Theme CSS -->

    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}" id="stylesheetLight">
    <link rel="stylesheet" href="{{ asset('assets/css/theme-dark.min.css') }}" id="stylesheetDark">

    <style>
        * {
            font-family: "DIN Next LT Arabic Regular";
            text-align: right;
        }

    </style>

    <!-- Title -->
    <title>{{ \App\Setting::all()->first()->title }} | تسجيل الدخول</title>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-156446909-1"></script><script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag("js", new Date());gtag("config", "UA-156446909-1");</script>

</head>
<body class="d-flex align-items-center bg-auth border-top border-top-2 border-primary">

<!-- CONTENT
================================================== -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-5 col-xl-4 my-5">

            <!-- Heading -->
            <h1 class="display-4 text-center mb-3">
               تسجيل الدخول
            </h1>

            <!-- Subheading -->
            <p class="text-muted text-center mb-5">
                الدخول الى لوحة تحكم المتجر
            </p>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}">
            @csrf

                <!-- Email address -->
                <div class="form-group">

                    <!-- Label -->
                    <label>البريد الإلكتروني</label>

                    <!-- Input -->
                    <input type="email" style="padding: 20px;"  placeholder="البريد الإلكتروني" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">

                    <div class="row">
                        <div class="col">

                            <!-- Label -->
                            <label>كلمة المرور</label>

                        </div>
                    </div> <!-- / .row -->

                    <!-- Input group -->
                    <div class="input-group input-group-merge">

                        <!-- Input -->
                        <input type="password" placeholder="كلمة المرور" class="form-control form-control-appended @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <!-- Icon -->
                        <div class="input-group-append">
                          <span class="input-group-text">
                          </span>
                        </div>

                    </div>
                </div>

                <!-- Submit -->
                <button class="btn btn-lg btn-block btn-primary mb-3" type="submit">
                    تسجيل الدخول
                </button>


            </form>

            <div>
                <div class="row">
                    <div class="col-12 ">
                        <div  style="text-align: center;color: #c1c1c1;direction: rtl">
                            جميع الحقوق محفوظة © {{ \App\Setting::all()->first()->title }} <br>
                            <div class="" style="text-align: center;color: #c1c1c1;">
                                <a href="https://twitter.com/MQ3b_" target="_blank" style="text-align: center;margin-top:10px;color: #c1c1c1;">برمجة: عبدالله العتيبي</a>
                            </div>
                        </div>
                    </div>
                </div> <!-- / .row -->
            </div>

        </div>
    </div> <!-- / .row -->
</div> <!-- / .container -->

<!-- JAVASCRIPT
================================================== -->
<!-- Libs JS -->

<!-- Map -->
<script src="{{ asset('assets/js/theme.min.js') }}"></script>
<script src="{{ asset('assets/js/dashkit.min.js') }}"></script>


</body>
</html>
