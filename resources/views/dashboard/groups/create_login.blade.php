@extends('dashboard.layouts.app')

@section('title','اضافة مجموعة')

@section('content')
    <div class="container-fluid">
        <div class="header-body ">
            <div class="row align-items-start">
                <div class="col-auto">

                    <!-- Button -->
                    <a href="{{ route('dashboard.groups.index') }}" class="btn btn-block btn-link text-muted">
                        العودة الى المجموعات
                    </a>
                </div>
                <div class="col text-right">

                    <!-- Pretitle -->
                    <h6 class="header-pretitle">
                        المجموعات
                    </h6>

                    <!-- Title -->
                    <h1 class="header-title">
                         مجموعة 36

                    </h1>

                </div>
            </div> <!-- / .row -->
        </div>

        <! ============ Form
        =======================>

        <br>
        <div class="col-lg-12 col-md-12" style="direction: rtl">
            <div class="row">
                <div class="col-lg-9 col-md-12">
                    <!-- Form -->
                    <form class="mb-4">

                        <!-- Project name -->
                        <div class="form-group">

                            <!-- Label  -->
                            <label>
                                الأجهزة المسجلة
                            </label>
                            <!-- Text -->
                            <small class="form-text text-muted">
                               تم ايجاد عدد من الاجهزة المسجلة في الشهادة
                            </small>

                            <!-- Input -->
                            <div class="card">
                                <div class="card-body">

                                    <!-- List group -->
                                    <div class="list-group list-group-flush my-n3">
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto">

                                                    <!-- Icon -->
                                                    <i class="fe fe-smartphone h1"></i>

                                                </div>
                                                <div class="col ml-n2">

                                                    <!-- Heading -->
                                                    <h4 class="mb-1">
                                                        iPhone 11
                                                    </h4>

                                                    <!-- Text -->
                                                    <small class="text-muted">
                                                        <time datetime="2020-04-20T16:16">April 20 at 4:16pm</time>
                                                    </small>

                                                </div>
                                                <div class="col-auto">

                                                    <!-- Button -->
                                                    <button class="btn btn-sm btn-white">
                                                        مفعل
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto">

                                                    <!-- Icon -->
                                                    <i class="fe fe-smartphone h1"></i>

                                                </div>
                                                <div class="col ml-n2">

                                                    <!-- Heading -->
                                                    <h4 class="mb-1">
                                                        iPhone X
                                                    </h4>

                                                    <!-- Text -->
                                                    <small class="text-muted">
                                                        <time datetime="2020-04-20T16:16">April 20 at 4:16pm</time>
                                                    </small>

                                                </div>
                                                <div class="col-auto">

                                                    <!-- Button -->
                                                    <button class="btn btn-sm btn-white">
                                                        مفعل
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto">

                                                    <!-- Icon -->
                                                    <i class="fe fe-smartphone h1"></i>

                                                </div>
                                                <div class="col ml-n2">

                                                    <!-- Heading -->
                                                    <h4 class="mb-1">
                                                        iPhone X MAX
                                                    </h4>

                                                    <!-- Text -->
                                                    <small class="text-muted">
                                                        <time datetime="2020-04-20T16:16">April 20 at 4:16pm</time>
                                                    </small>

                                                </div>
                                                <div class="col-auto">

                                                    <!-- Button -->
                                                    <button class="btn btn-sm btn-white">
                                                        مفعل
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="text-center mt-2">
                                               يوجد اكثر من 50+ جهاز
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>


                        <!-- Buttons -->
                        <a href="#" class="btn btn-block btn-primary">
                           اضافة كل الاجهزة
                        </a>

                    </form>
                </div>
                <div class="col-lg-3 col-md-12">
                    <div class="row">
                        <div class="col-12">

                            <!-- Warning -->
                            <div class="card bg-success border">
                                <div class="card-body">

                                    <!-- Heading -->
                                    <h4 class="mb-3 text-white">
                                        <i class="fe fe-alert-triangle"></i> بنجاح
                                    </h4>

                                    <!-- Text -->
                                    <p class="small text-white mb-2">
                                        تم تسجيل دخولك بنجاح لحساب المطورين وتفعيل ، التفعيل التلقائي
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
