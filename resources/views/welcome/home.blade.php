@extends('welcome')
@section('content')


    <!-- WELCOME
      ================================================== -->
    <section data-jarallax data-speed=".8" class="py-10 py-md-14 overlay overlay-black overlay-60 bg-dark jarallax"
             style="background-image: url({{ asset('assets/welcome/img/patterns/pattern-1.svg')}});" >
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8 text-center">

                    <!-- Heading -->
                    <h1 class="display-2 text-white">
                        متجر
                        <span class="text-primary-desat"> {{ \App\Setting::all()->first()->title }} </span>
                        يقدم لك الاشتراكات في تطبيقات البلس والتطبيقات المعدلة

                    </h1>

                    <!-- Text -->
                    <p class="lead text-white-75 mb-6">
                        {{ \App\Setting::all()->first()->description }}
                    </p>

                    <!-- Button -->
                    <a href="{{ \Illuminate\Support\Facades\URL::to('/storage/mobileconfig/udid.mobileconfig') }}" class="btn btn-primary-desat lift">
                        طلب اشتراك<i class="fe fe-arrow-left ml-3"></i>
                    </a>
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section>

    <!-- SHAPE
    ================================================== -->
    <div class="position-relative">
        <div class="shape shape-bottom shape-fluid-x svg-shim text-light">
            <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"/>
            </svg>
        </div>
    </div>

    <!-- BENEFITS
  ================================================== -->
    <section class="py-8 py-md-11">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-12 col-md-5 order-md-2 rtl-text">

                    <!-- Badge -->
                    <span class="badge badge-primary-desat-soft badge-pill mb-3">
              <span class="h6 text-uppercase">
                سؤال
              </span>
            </span>

                    <!-- Heading -->
                    <h2>
                        كيف يعمل {{ \App\Setting::all()->first()->title }}؟ <br>
                    </h2>

                    <!-- Text -->
                    <p class="font-size-lg text-muted mb-6 mb-md-0">
                        من خلال {{ \App\Setting::all()->first()->title }} يمكن طلب اشتراك ويتم تفعيل حسابك في اقل من 24 ساعة و يمكنك الاستمتاع بتوقيع وتحميل التطبيقات بشكل لانهائي.
                    </p>

                </div>
                <div class="col-12 col-md-6 order-md-1">

                    <!-- Card -->
                    <div class="card card-border border-primary-desat shadow-lg">
                        <div class="card-body">

                            <!-- List group -->
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex align-items-center">

                                    <!-- Text -->
                                    <div class="ml-auto rtl-text">

                                        <!-- Heading -->
                                        <p class="font-weight-bold mb-1">
                                            طلب اشتراك
                                        </p>

                                        <!-- Text -->
                                        <p class="font-size-sm text-muted mb-0">
                                            قبل الطلب الاشتراك عليك قراءة شروط المتجر لحفظ حقوقك كمشترك، ثم قم بطلب اشتراك جديد
                                        </p>

                                    </div>

                                    <!-- Check -->
                                    <div class="badge badge-rounded-circle badge-primary-desat-soft ml-4">
                                        <i class="fe fe-check"></i>
                                    </div>

                                </div>
                                <div class="list-group-item d-flex align-items-center">

                                    <!-- Text -->
                                    <div class="ml-auto rtl-text">

                                        <!-- Heading -->
                                        <p class="font-weight-bold mb-1">
                                            انتظار رسالة التفعيل
                                        </p>

                                        <!-- Text -->
                                        <p class="font-size-sm text-muted mb-0">
                                            يتم تفعيل الحساب ما بين 10 دقائق و 24 ساعة كحد اقصى
                                        </p>

                                    </div>

                                    <!-- Check -->
                                    <div class="badge badge-rounded-circle badge-primary-desat-soft ml-4">
                                        <i class="fe fe-check"></i>
                                    </div>

                                </div>
                                <div class="list-group-item d-flex align-items-center">

                                    <!-- Text -->
                                    <div class="ml-auto rtl-text">

                                        <!-- Heading -->
                                        <p class="font-weight-bold mb-1">
                                            تحميل المتجر
                                        </p>

                                        <!-- Text -->
                                        <p class="font-size-sm text-muted mb-0">
                                            بعد تحميلك المتجر يمكنك الاستمتاع في توقيع التطبيقات و تحميلها بشكل لانهائي
                                        </p>

                                    </div>

                                    <!-- Check -->
                                    <div class="badge badge-rounded-circle badge-primary-desat-soft ml-4">
                                        <i class="fe fe-check"></i>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section>


    <!-- INTEGRATION
   ================================================== -->
    <section class="py-8 py-md-11">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8 text-center rtl-text">

                    <!-- Heading -->
                    <h1 class="font-weight-bold">
                        لماذا {{ \App\Setting::all()->first()->title }}؟
                    </h1>

                    <!-- Text -->
                    <p class="font-size-lg text-muted mb-7 mb-md-9">
                        يتميز {{ \App\Setting::all()->first()->title }} في سرعة تفعيل الاشتراك وتوفر التحديث الجديدة اول بأول وتعويض المشتركين.
                    </p>

                </div>
            </div> <!-- / .row -->
            <div class="row no-gutters mb-7 mb-md-9">
                <div class="col-12 col-md-4 text-center">

                    <div class="row mb-5">
                        <div class="col">

                            <!-- Placeholder -->

                        </div>
                        <div class="col-auto">

                            <!-- Icon -->
                            <div class="icon text-primary-desat mb-3">
                                <i class="fad fa-hammer"></i>
                            </div>

                        </div>
                        <div class="col">

                            <!-- Divider -->
                            <hr class="d-none d-md-block">

                        </div>
                    </div> <!-- / .row -->

                    <!-- Headin -->
                    <h3 class="font-weight-bold font-arabic-text">
                        تطبيقات لانهائية
                    </h3>

                    <!-- Text -->
                    <p class="text-muted mb-6 mb-md-0 font-arabic-text">
                        من خلال ميزة التوقيع التلقائي يمكنك توقيع عدد لانهائي من التطبيقات
                    </p>

                </div>
                <div class="col-12 col-md-4 text-center">

                    <div class="row mb-5">
                        <div class="col">

                            <!-- Divider -->
                            <hr class="d-none d-md-block">

                        </div>
                        <div class="col-auto">

                            <!-- Icon -->
                            <div class="icon text-primary-desat mb-3">
                                <i class="fad fa-sack-dollar"></i>
                            </div>

                        </div>
                        <div class="col">

                            <!-- Divider -->
                            <hr class="d-none d-md-block">

                        </div>
                    </div> <!-- / .row -->

                    <!-- Headin -->
                    <h3 class="font-weight-bold font-arabic-text">
                        بسعر رمز جداً
                    </h3>

                    <!-- Text -->
                    <p class="text-muted mb-6 mb-md-0 font-arabic-text">
                        مقارنتاً بسعار المنفسين المتجر سعر الاشتراك لدينا رمزي جداً
                    </p>

                </div>
                <div class="col-12 col-md-4 text-center">

                    <div class="row mb-5">
                        <div class="col">

                            <!-- Divider -->
                            <hr class="d-none d-md-block">

                        </div>
                        <div class="col-auto ">

                            <!-- Icon -->
                            <div class="icon text-primary-desat mb-3">
                                <i class="fad fa-hourglass-end"></i>
                            </div>

                        </div>
                        <div class="col">
                            <!-- Placeholder -->
                        </div>
                    </div> <!-- / .row -->

                    <!-- Headin -->
                    <h3 class="font-weight-bold font-arabic-text">
                        سرعة التفعيل
                    </h3>

                    <!-- Text -->
                    <p class="text-muted mb-0 font-arabic-text">
                        يتم تفعيل المشترك غالباً بين 10 دقائق و 24 ساعة كحد اقصى
                    </p>

                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section>


    <section class="py-8 py-md-11">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-12 col-md-6 col-lg-7 order-md-2">

                    <!-- Image -->
                    <img src="{{ asset('assets/welcome/img/resign.jpeg') }}" style="
    width: 300px;
    float: right;
    margin-right: 100px;
    border-radius: 20px;
" alt="..." class="img-fluid mb-6 mb-md-8 mb-md-0 aos-init aos-animate" data-aos="fade-left">

                </div>
                <div class="col-12 col-md-6 col-lg-5 order-md-1 aos-init aos-animate" data-aos="fade-right">

                    <!-- Heading -->
                    <h2 class="font-weight-bold" style="text-align: right;">
                        التوقيع التلقائي 🤖
                    </h2>

                    <!-- Text -->
                    <p class="font-size-lg text-muted mb-0" style="text-align: right;">
                        من خلال التوقيع التلقائي يمكن تحميل عدد لانهائي من التطبيقات من خلال المتجر او من خارجه عن طريق رابط
                    </p>

                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section>


    <section class="pt-6 pt-md-8">
        <div class="container">
            <div class="row align-items-center justify-content-center justify-content-md-between" style="direction: inherit !important;">
                <div class="col-10 col-sm-8 col-md-6 order-md-2">

                    <!-- iPhone + iPhone -->
                    <div class="device-combo device-combo-iphonex-iphonex mb-6 mb-md-0">

                        <!-- iPhone -->
                        <div class="device device-iphonex aos-init aos-animate" data-aos="fade-left">
                            <img src="{{ asset('assets/welcome/img/home.jpeg') }}" style="border-radius: 20px;" class="device-screen" alt="...">
                            <img src="{{ asset('assets/welcome/img/apps.jpeg') }}" style="border-radius: 20px;" class="img-fluid" alt="...">
                        </div>

                        <!-- iPhone -->
                        <div class="device device-iphonex aos-init aos-animate" data-aos="fade-left" data-aos-delay="150">
                            <img src="{{ asset('assets/welcome/img/apps.jpeg') }}" style="border-radius: 20px;" class="device-screen" alt="...">
                            <img src="{{ asset('assets/welcome/img/home.jpeg') }}" style="border-radius: 20px;" class="img-fluid" alt="...">
                        </div>

                    </div>

                </div>
                <div class="col-12 col-md-6 col-lg-5 aos-init aos-animate" data-aos="fade-right">

                    <!-- Heading -->
                    <h1 class="font-weight-bold"  style="text-align: right;     margin-top: 75px;">😍 تطبيق المتجر
                    </h1>

                    <!-- Text -->
                    <p class="font-size-lg text-muted mb-6" style="text-align: right;">
                        يمكنك رؤية تطبيق المتجر في الصورة الجانبية وبين لك التصميم الانيق للمتجر وبين لك سهولة استخدامة.
                    </p>

                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section>

    <!-- SHAPE
    ================================================== -->
    <div class="position-relative ">
        <div class="shape shape-bottom shape-fluid-x svg-shim text-dark">
            <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"/>
            </svg>
        </div>
    </div>

    <!-- FOOTER
    ================================================== -->
    <section class=" bg-dark section-rtl">
        <footer class="py-8 py-md-11 bg-dark border-top border-gray-800-50">
            <div class="container">
                <div class="row">
                    <div class="col-12 ">
                        <div  style="text-align: center;color: #c1c1c1;">
                            جميع الحقوق محفوظة © {{ \App\Setting::all()->first()->title }} <br>
                            <div class="">
                                <a href="https://twitter.com/MQ3b_" target="_blank" style="color: #fff;">برمجة: عبدالله العتيبي</a>
                            </div>
                        </div>
                    </div>
                </div> <!-- / .row -->
            </div> <!-- / .container -->
        </footer>
    </section>

@endsection
