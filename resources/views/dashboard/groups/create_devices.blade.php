@extends('dashboard.layouts.app')

@section('title','ارسال رسالة sms للمصادقة')

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
                        ارسال رسالة sms للمصادقة
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
                    <form class="mb-4" action="{{ route('dashboard.groups.store') }}" method="post">
                        @csrf
                        @method('post')
                        <input name="page_id" value="select_devices" hidden>
                        <input name="scnt" value="{{ $scnt }}" hidden>
                        <input name="group_id" value="{{ $group_id }}" hidden>
                        <input name="JSESSIONID" value="{{ $JSESSIONID }}" hidden>
                        <!-- Project name -->
                        <div class="form-group">

                            <!-- Label  -->
                            <label>
                               حدد رقم الجوال
                            </label>
                            <!-- Text -->
                            <small class="form-text text-muted">
                               الرجاء تحديد رقم الجوال لارسال كود التحقق عليه.
                            </small>

                            <!-- Input -->
                            <select class="custom-select" data-toggle="select" name="device_id">
                                @foreach($devices as $device)
                                    <option value="{{ $device['deviceID'] }}">{{ $device['devicesText'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Buttons -->
                        <button type="submit" class="btn btn-block btn-primary">
                            ارسال كود التحقق
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
                                        <i class="fe fe-alert-triangle"></i> تنيبة
                                    </h4>

                                    <!-- Text -->
                                    <p class="small text-muted mb-2">
                                        1- الرجاء تحديد رقم الجوال الصحيح
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
