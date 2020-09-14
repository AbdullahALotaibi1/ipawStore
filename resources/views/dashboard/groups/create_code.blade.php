@extends('dashboard.layouts.app')

@section('title','التحقق من كود مصادقة الدخول')

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
                        التحقق من كود مصادقة الدخول
                    </h1>

                </div>
            </div> <!-- / .row -->
        </div>

        <! ============ Form
        =======================>

        <br>

        @if(isset($errorMessage))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>حدث خطاء في كود التحقق:</strong>  {{ $errorMessage }}
            <!-- Button -->
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
        <div class="col-lg-12 col-md-12" style="direction: rtl">
            <div class="row">
                <div class="col-lg-9 col-md-12">
                    <!-- Form -->
                    <form class="mb-4" action="{{ route('dashboard.groups.store') }}" method="post">
                        @csrf
                        @method('post')
                        <input name="page_id" value="send_code" hidden>
                        <input name="scnt" value="{{ $scnt }}" hidden>
                        <input name="group_id" value="{{ $group_id }}" hidden>
                        <input name="JSESSIONID" value="{{ $JSESSIONID }}" hidden>

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
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control form-control-prepended "
                                       placeholder="مثال: 000000"
                                       name="login_code"
                                >
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-unlock-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <button type="submit" class="btn btn-block btn-primary">
                           التحقق من الكود
                        </button>
                    </form>


                    <form action="{{ route('dashboard.groups.store') }}" method="post">
                    @csrf
                    @method('post')
                        <input name="send_to_phone" value="1" hidden>
                        <input name="scnt" value="{{ $scnt }}" hidden>
                        <input name="group_id" value="{{ $group_id }}" hidden>
                        <input name="page_id" value="send_code" hidden>
                        <!-- Project name -->
                        <div class="form-group">

                            <!-- Label  -->
                            <label>
                                التحقق بطريقة اخرى
                            </label>
                            <!-- Text -->
                            <small class="form-text text-muted">
                                ارسال الكود  التحقق عن طريق الجوال
                            </small>

                            <!-- Input -->
                            <button class="btn btn-dark">
                                <i class="fas fa-sms" style="margin-left: 4px"></i>
                                التحقق عن طريق الجوال
                            </button>
                        </div>
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
                                        <i class="fe fe-alert-triangle"></i> تنيبة
                                    </h4>

                                    <!-- Text -->
                                    <p class="small text-muted mb-2">
                                        1- في بعض الاحيان تتاخر وصل رسالة التحقق
                                    </p>
                                    <p class="small text-muted mb-0">
                                        2- في حال عدم وصول رسالة التحقق قم بالضغط على زر <strong>التحقق عن طريق الجوال</strong>
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
