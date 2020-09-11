

@extends('dashboard.layouts.app')

@section('title','اضافة حساب جديد')

@section('content')
    <div class="container-fluid">
        <div class="header-body ">
            <div class="row align-items-start">
                <div class="col-auto">

                    <!-- Button -->
                    <a href="{{ route('dashboard.accounts.index') }}" class="btn btn-block btn-link text-muted">
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
        @if(session()->has('appleMessage'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>حدث خطاء في حساب المطورين:</strong>  {{ session()->get('appleMessage') }}
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
                    <form class="mb-4" action="{{ route('dashboard.accounts.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <!-- group name -->
                        <div class="form-group">
                            <!-- Label  -->
                            <label>
                               اسم البنك
                            </label>

                            <!-- Input -->
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control form-control-prepended @error('bank_name') is-invalid @enderror"
                                       placeholder="مثال: بنك الراجحي"
                                       name="bank_name"
                                       value="{{ old('bank_name') }}"
                                >
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-university"></i>
                                    </div>
                                </div>
                                @error('bank_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Divider -->
                        <hr class="mt-4 mb-5">


                        <!-- upload files -->
                        <div class="form-group">

                            <!-- Label -->
                            <label class="mb-1">
                                شعار البنك
                            </label>

                            <!-- Text -->
                            <small class="form-text text-muted">
                              الرجاء رفع شعار البنك و ان لايتجاوز حجمة 2MB
                            </small>

                            <!-- Card -->
                            <div class="card">
                                <div class="card-body">

                                    <div class="upload-single-file">
                                        <input type="file" accept="image/*" name="bank_image">
                                        <p class="message-upload-file">قم بضغط هنا لرفع شعار البنك </p>
                                    </div>

                                    @error('bank_image')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <!-- Label  -->
                            <label>
                               اسم صاحب الحساب
                            </label>
                            <!-- Text -->
                            <small class="form-text text-muted">
                               الرجاء كتابة اسم صاحب الحساب الصحيح حتى لا يكون هناك خطاء في عملية التحويل للمشترك
                            </small>
                            <!-- Input -->
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control form-control-prepended @error('owner_name') is-invalid @enderror"
                                       placeholder="مثال: عبدالله العتيبي"
                                       name="owner_name"
                                       value="{{ old('owner_name') }}"
                                >
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                @error('owner_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <!-- Label  -->
                            <label>
                                رقم الحساب
                            </label>
                            <small class="form-text text-muted">
                               في بعض الاحيان يفضل المشترك رقم الحساب لسرعة تحويل المبلغ
                            </small>
                            <!-- Input -->
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control form-control-prepended @error('account_number') is-invalid @enderror"
                                       placeholder="مثال: 84XXXXXXXXXXXXXX"
                                       name="account_number"
                                       value="{{ old('account_number') }}"
                                >
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-money-check"></i>
                                    </div>
                                </div>
                                @error('account_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <!-- Label  -->
                            <label>
                                IBAN
                            </label>
                            <small class="form-text text-muted">
                               يفضل كتابة رقم IBAN لعملية التحويل من بنك الى بنك اخرى
                            </small>
                            <!-- Input -->
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control form-control-prepended @error('iban') is-invalid @enderror"
                                       placeholder="مثال: SA 8000XXXXXXXXXXXXXXXXXXX"
                                       name="iban"
                                       value="{{ old('iban') }}"
                                >
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-pen"></i>
                                    </div>
                                </div>
                                @error('iban')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>


                        <!-- Divider -->
                        <hr class="mt-5 mb-5">

                        <!-- Buttons -->
                        <button type="submit" class="btn btn-block btn-primary">
                           اضافة
                        </button>

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
                                        الرجاء التاكد من صحة البيانات المكتوبة لتجنب حدوث اخطاء اثناء عملية التحويل
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


@section('javascript')
    <script>
        $(document).ready(function(){
            $('.upload-single-file input').change(function (e) {
                $('.upload-single-file p').text(" ملف واحد محدد ("+ e.target.files[0].name +")");
            });
        });
    </script>
@endsection
