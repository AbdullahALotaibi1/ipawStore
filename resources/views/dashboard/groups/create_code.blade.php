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
                        اضافة مجموعة
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
                               كود التحقق
                            </label>
                            <!-- Text -->
                            <small class="form-text text-muted">
                             الرجاء ادخل كود التحقق الخاص بحساب المطورين
                            </small>

                            <!-- Input -->
                            <input type="text" class="form-control" placeholder="Example: 000000">

                        </div>


                        <!-- Buttons -->
                        <a href="#" class="btn btn-block btn-primary">
                           التحقق من الكود
                        </a>

                    </form>
                </div>
                <div class="col-lg-3 col-md-12">
                    <div class="row">
                        <div class="col-12">

                            <!-- Warning -->
                            <div class="card bg-light border">
                                <div class="card-body">

                                    <!-- Heading -->
                                    <h4 class="mb-3">
                                        <i class="fe fe-alert-triangle"></i> تحذير
                                    </h4>

                                    <!-- Text -->
                                    <p class="small text-muted mb-2">
                                        1- الرجاء التاكد من صحة ملف p12 حتى يتم توقيع التطبيقات بشكل صحيح
                                    </p>
                                    <p class="small text-muted mb-0">
                                        2- الرجاء التاكد من صحة بيانات حساب المطورين وتحديد طريقة استقبال الكود و تفعيل الحساب
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
