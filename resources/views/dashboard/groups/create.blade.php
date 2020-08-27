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
                                اسم المجموعة
                            </label>
                            <!-- Text -->
                            <small class="form-text text-muted">
                                اسم المجموعة سيظهر للمشتركين
                            </small>

                            <!-- Input -->
                            <input type="text" class="form-control" placeholder="Example: Pro3">

                        </div>


                        <!-- Divider -->
                        <hr class="mt-4 mb-5">


                        <!-- Starting files -->
                        <div class="form-group">

                            <!-- Label -->
                            <label class="mb-1">
                                رفع الملف .p12
                            </label>

                            <!-- Text -->
                            <small class="form-text text-muted">
                                الرجاء رفع ملف .p12 بعد استخراجه من سلسلة المفاتيح
                            </small>

                            <!-- Card -->
                            <div class="card">
                                <div class="card-body">

                                    <!-- Dropzone -->
                                    <div class="dropzone dropzone-multiple" data-toggle="dropzone" data-options='{"url": "https://"}'>

                                        <!-- Fallback -->
                                        <div class="fallback">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="customFileUpload" multiple>
                                                <label class="custom-file-label" for="customFileUpload">Choose file</label>
                                            </div>
                                        </div>

                                        <!-- Preview -->
                                        <ul class="dz-preview dz-preview-multiple list-group list-group-lg list-group-flush">
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">

                                                        <!-- Image -->
                                                        <div class="avatar">
                                                            <img class="avatar-img rounded" src="data:image/svg+xml,%3csvg3c/svg%3e" alt="..." data-dz-thumbnail>
                                                        </div>

                                                    </div>
                                                    <div class="col ml-n3">

                                                        <!-- Heading -->
                                                        <h4 class="mb-1" data-dz-name>...</h4>

                                                        <!-- Text -->
                                                        <p class="small text-muted mb-0" data-dz-size></p>

                                                    </div>
                                                    <div class="col-auto">

                                                        <!-- Dropdown -->
                                                        <div class="dropdown">

                                                            <!-- Toggle -->
                                                            <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fe fe-more-vertical"></i>
                                                            </a>

                                                            <!-- Menu -->
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a href="#" class="dropdown-item" data-dz-remove>
                                                                    Remove
                                                                </a>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <hr class="mt-5 mb-5">

                        <div class="row">
                            <div class="col-12 col-md-6">

                                <!-- Start date -->
                                <div class="form-group">

                                    <!-- Label -->
                                    <label>
                                        البريد الاكتروني
                                    </label>
                                    <small class="form-text text-muted">
                                       البريد الالكتروني الخاص بحساب الشهادة في موقع مطورين ابل
                                    </small>

                                    <!-- Input -->
                                    <input type="text" class="form-control" placeholder="Example: apple@gmail.com">

                                </div>

                            </div>
                            <div class="col-12 col-md-6">

                                <!-- Start date -->
                                <div class="form-group">

                                    <!-- Label -->
                                    <label>
                                        كلمة المرور
                                    </label>
                                    <small class="form-text text-muted">
                                        كلمة المرور الخاص بحساب الشهادة في موقع مطورين ابل
                                    </small>

                                    <!-- Input -->
                                    <input type="text" class="form-control" placeholder="**********">

                                </div>

                            </div>
                        </div> <!-- / .row -->


                        <div class="row">
                            <div class="col-12 col-md-6">

                                <!-- Private project -->
                                <div class="form-group">

                                    <!-- Label -->
                                    <label class="mb-1">
                                       تحديد طريقة تفعيل الحساب
                                    </label>

                                    <!-- Text -->
                                    <small class="form-text text-muted">
                                       الرجاء تحديد طريقة استقبال كود تفعيل الحساب الخاص بك اما عن طريق استلام الكود على الماك الخاص بك او على رسالة sms على الجوال المسجل في الشهادة
                                    </small>

                                    <div class="btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-white">
                                            <input type="radio" name="options" id="option1" checked=""> <i class="fe fe-monitor"></i> جهاز الماك
                                        </label>
                                        <label class="btn btn-white">
                                            <input type="radio" name="options" id="option2"> <i class="fe fe-smartphone"></i> رسالة sms
                                        </label>
                                    </div>

                                </div>

                            </div>

                        </div> <!-- / .row -->

                        <!-- Buttons -->
                        <a href="#" class="btn btn-block btn-primary">
                            تفعيل الحساب
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
