@extends('dashboard.layouts.app')

@section('title','  تعديل - '.$app->app_name.'')

@section('content')
    <div class="container-fluid">
        <div class="header-body ">
            <div class="row align-items-start">
                <div class="col-auto">

                    <!-- Button -->
                    <a href="{{ route('dashboard.applications.index') }}" class="btn btn-block btn-link text-muted">
                        العودة الى التطبيقات
                    </a>
                </div>
                <div class="col text-right">

                    <!-- Pretitle -->
                    <h6 class="header-pretitle">
                        التطبيقات
                    </h6>

                    <!-- Title -->
                    <h1 class="header-title" style="direction: rtl">
                       تعديل - {{ $app->app_name }}
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
          <form class="mb-4" action="{{ route('dashboard.applications.update', $app->id) }}" method="post" >
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <!-- Form -->
                        @csrf
                        @method('put')
                    <!-- group name -->
                    <div class="form-group">
                        <!-- Label  -->
                        <label>
                            اسم التطبيق
                        </label>
                        <!-- Text -->
                        <small class="form-text text-muted">
                            اسم التطبيق سيظهر للمشتركين
                        </small>

                        <!-- Input -->
                        <div class="input-group input-group-merge">
                            <input type="text" class="form-control form-control-prepended @error('app_name') is-invalid @enderror"
                                   name="app_name"
                                   value="{{ old('app_name', $app->app_name) }}"
                            >
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-pen"></i>
                                </div>
                            </div>
                            @error('app_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>


                    <!-- group name -->
                    <div class="form-group">
                        <!-- Label  -->
                        <label>
                            اصدار التطبيق
                        </label>
                        <!-- Text -->
                        <small class="form-text text-muted">
                            اصدار التطبيق سيظهر للمشتركين
                        </small>

                        <!-- Input -->
                        <div class="input-group input-group-merge">
                            <input type="text" class="form-control form-control-prepended @error('app_version') is-invalid @enderror"
                                   name="app_version"
                                   value="{{ old('app_version', $app->app_version) }}"
                            >
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-pen"></i>
                                </div>
                            </div>
                            @error('app_version')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                        <!-- Divider -->
                        <hr class="mt-4 mb-5">


                </div>

                    <div class="col-lg-6 col-md-12">
                        <!-- group name -->
                        <div class="form-group">
                            <!-- Label  -->
                            <label>
                                بندل التطبيق
                            </label>
                            <!-- Text -->
                            <small class="form-text text-muted">
                                بندل التطبيق لن يظهر للمشتركين
                            </small>

                            <!-- Input -->
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control form-control-prepended @error('app_bundle') is-invalid @enderror"
                                       name="app_bundle"
                                       value="{{ old('app_bundle', $app->app_bundle) }}"
                                >
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-pen"></i>
                                    </div>
                                </div>
                                @error('app_bundle')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- Label  -->
                            <label>
                                حجم التطبيق
                            </label>
                            <!-- Text -->
                            <small class="form-text text-muted">
                                جحم التطبيق  سيظهر للمشتركين وغير قابل لتعديل
                            </small>

                            <!-- Input -->
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control form-control-prepended"
                                       value="{{ $app->app_size }}"
                                       disabled
                                >
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-pen"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <hr class="mt-4 mb-5">

                    </div>

                <div class="col-lg-12 col-md-12">
                    <!-- Buttons -->
                    <button type="submit" class="btn btn-block btn-primary">
                        حفظ التعديلات
                    </button>
                </div>
            </div>
            </form>

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
