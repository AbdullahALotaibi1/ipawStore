

@extends('dashboard.layouts.app')

@section('title',' تعديل - '. $customer->full_name .' ')

@section('content')
    <div class="container-fluid">
        <div class="header-body ">
            <div class="row align-items-start">
                <div class="col-auto">

                    <!-- Button -->
                    <a href="{{ route('dashboard.customers.index') }}" class="btn btn-block btn-link text-muted">
                        العودة الى التطبيقات
                    </a>
                </div>
                <div class="col text-right">

                    <!-- Pretitle -->
                    <h6 class="header-pretitle">
                        المشتركين
                    </h6>

                    <!-- Title -->
                    <h1 class="header-title" style="direction: rtl">
                        تعديل - {{ $customer->full_name }}
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
            <form class="mb-4" action="{{ route('dashboard.customers.update', $customer->id) }}" method="post" >
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <!-- Form -->
                    @csrf
                    @method('put')
                    <!-- group name -->
                        <div class="form-group">
                            <!-- Label  -->
                            <label>
                                اسم المشترك
                            </label>

                            <!-- Input -->
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control form-control-prepended @error('full_name') is-invalid @enderror"
                                       name="full_name"
                                       value="{{ old('full_name', $customer->full_name) }}"
                                >
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-pen"></i>
                                    </div>
                                </div>
                                @error('full_name')
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
                                udid
                            </label>

                            <!-- Input -->
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control form-control-prepended"
                                       value="{{ old('udid', $customer->udid) }}"
                                       disabled
                                >
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-pen"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- group name -->
                        <div class="form-group">
                            <!-- Label  -->
                            <label>
                                نوع الجهاز
                            </label>

                            <!-- Input -->
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control form-control-prepended"
                                       value="{{ old('device_type', $customer->device_type) }}"
                                       disabled
                                >
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-pen"></i>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- group name -->
                        <div class="form-group">
                            <!-- Label  -->
                            <label>
                                حالة المشترك
                            </label>
                            <!-- Input -->
                            <select class="custom-select" data-toggle="select" name="status">
                                <option value="{{ \App\ConstantsHelper::ACTIVE_CUSTOMER }}" {{ $customer->status == \App\ConstantsHelper::ACTIVE_CUSTOMER ? 'selected' : '' }}>مفعل</option>
                                <option value="{{ \App\ConstantsHelper::DISABLED_CUSTOMER }}" {{ $customer->status == \App\ConstantsHelper::DISABLED_CUSTOMER ? 'selected' : '' }}>معلق</option>
                                <option value="{{ \App\ConstantsHelper::NEED_UPDATE_PROFILE_CUSTOMER }}" {{ $customer->status == \App\ConstantsHelper::NEED_UPDATE_PROFILE_CUSTOMER ? 'selected' : '' }}>بحاجة لتحديث بيانات حسابة</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <!-- group name -->
                        <div class="form-group">
                            <!-- Label  -->
                            <label>
                               رقم الجوال
                            </label>

                            <!-- Input -->
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control form-control-prepended @error('phone_number') is-invalid @enderror"
                                       name="phone_number"
                                       value="{{ old('phone_number', $customer->phone_number) }}"
                                >
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-pen"></i>
                                    </div>
                                </div>
                                @error('phone_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- Label  -->
                            <label>
                                كوبون التسجيل
                            </label>

                            <!-- Input -->
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control form-control-prepended"
                                       value="{{ $customer->phone_number }}"
                                       disabled
                                >
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-pen"></i>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- group name -->
                        <div class="form-group">
                            <!-- Label  -->
                            <label>
                                موديل الجهاز
                            </label>

                            <!-- Input -->
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control form-control-prepended"
                                       value="{{ old('device_type', $customer->device_model) }}"
                                       disabled
                                >
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-pen"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-12 col-md-12">
                        <!-- Divider -->
                        <hr class="mt-4 mb-5">
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

