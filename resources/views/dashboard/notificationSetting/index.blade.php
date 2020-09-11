@extends('dashboard.layouts.app')

@section('title','الاشعارات')

@section('content')
    <div class="container-fluid">
        <div class="header-body ">
            <div class="row align-items-start">
                <div class="col text-right">

                    <!-- Pretitle -->
                    <h6 class="header-pretitle">
                        لوحة التحكم
                    </h6>

                    <!-- Title -->
                    <h1 class="header-title">
                        الاشعارات
                    </h1>

                </div>
            </div> <!-- / .row -->
        </div>

        <br>


        <! ============ Static
        =====================>
        <div class="row " style="direction: rtl">
            @if(Session::has('message'))
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
                                {{ Session::get('message') }}
                            </p>
                        </div>
                    </div>

                </div>
            @endif
        </div>


        <! ============ Table
        =======================>

        <!-- Card -->
        <div class="card" data-list='{"valueNames": ["order_id", "full_name", "phone_number", "udid"]}'>
            <div class="card-header">
                اعدادات OneSingle
            </div>
            <div class="card-body">
                <div class="row" style="direction: rtl">
                    <div class="col-md-12">
                        <!-- group name -->
{{--                        <div class="form-group">--}}
{{--                            <!-- Label  -->--}}
{{--                            <label>--}}
{{--                                نوع الجهاز--}}
{{--                            </label>--}}
{{--                            <!-- Text -->--}}
{{--                            <small class="form-text text-muted">--}}
{{--                                بندل التطبيق لن يظهر للمشتركين--}}
{{--                            </small>--}}
{{--                            <!-- Input -->--}}
{{--                            <div class="input-group input-group-merge">--}}
{{--                                <input type="text" class="form-control form-control-prepended"--}}
{{--                                       value="{{ old('device_type') }}"--}}
{{--                                       disabled--}}
{{--                                >--}}
{{--                                <div class="input-group-prepend">--}}
{{--                                    <div class="input-group-text">--}}
{{--                                        <i class="fas fa-pen"></i>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection




