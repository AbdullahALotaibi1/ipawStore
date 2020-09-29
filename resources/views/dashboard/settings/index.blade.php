@extends('dashboard.layouts.app')

@section('title','الاعدادات العامة')

@section('content')
            <div class="container-fluid">
                <div class="header-body ">
                    <div class="row align-items-start">
                        <div class="col-auto">
                        </div>
                        <div class="col text-right">

                            <!-- Pretitle -->
                            <h6 class="header-pretitle">
                                لوحة التحكم
                            </h6>

                            <!-- Title -->
                            <h1 class="header-title" style="direction: rtl">
                                الاعدادات العامة
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

                @if($errors->any())
                    <div class="col-12">

                        <!-- Warning -->
                        <div class="card bg-danger border">
                            <div class="card-body">

                                <!-- Heading -->
                                <h4 class="mb-3 text-white">
                                    <i class="fe fe-alert-triangle"></i> حدث خطاء
                                </h4>

                                <!-- Text -->
                                @foreach($errors->all() as $error)
                                    <p class="small text-white mb-2">
                                       {{ $error }}
                                    </p>
                                @endforeach
                            </div>
                        </div>

                    </div>
                @endif
        </div>



                <form method="post" action="{{ route('dashboard.settings.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('post')
        <!-- Card -->
        <div class="card">
            <div class="card-header">
                اعدادات المتجر
            </div>
            <div class="card-body">
                <div class="row" style="direction: rtl">
                    <div class="col-md-6">
                        <!-- group name -->
                            <div class="form-group">
                                <!-- Label  -->
                                <label>
                                    اسم المتجر
                                </label>
                                <!-- Text -->
                                <small class="form-text text-muted">
                                    سيظهر اسم المتجر للمشتركين والزوار
                                </small>
                                <!-- Input -->
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control form-control-prepended"
                                           value="{{ old('title', $settings->title) }}"
                                           name="title"
                                    >
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-pen"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div class="col-md-6">
                        <!-- group name -->
                        <div class="form-group">
                            <!-- Label  -->
                            <label>
                               بندل المتجر
                            </label>
                            <!-- Text -->
                            <small class="form-text text-muted">
                                لن يظهر للمشتركين او الزوار
                            </small>
                            <!-- Input -->
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control form-control-prepended"
                                       value="{{ old('app_bundle', $settings->app_bundle) }}"
                                       name="app_bundle"
                                >
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-pen"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">

                            <!-- Label -->
                            <label class="mb-1">
                                شعار المتجر
                            </label>

                            <!-- Text -->
                            <small class="form-text text-muted">
                                يساعدك شعار المتجر لعكس انطباع جيد لزائر بإن لديك هوية جيدة
                            </small>

                            <!-- Card -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="upload-single-file">
                                        <input type="file"  accept="image/*" name="logo_store">
                                        <p class="message-upload-file">قم بضغط هنا لرفع ملف شعار المتجر </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <!-- group name -->
                        <div class="form-group">
                            <!-- Label  -->
                            <label>
                               وصف المتجر
                            </label>
                            <!-- Text -->
                            <small class="form-text text-muted">
                                يحسن وصف المتجر من ظهورك في محركات قوقل
                            </small>
                            <!-- Input -->
                            <textarea class="form-control" name="description" placeholder="متجر (اسم المتجر) يقدم لك الاشتراكات في تطبيقات البلس والتطبيقات المعدلة">{{ old('description', $settings->description) }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <!-- group name -->
                        <div class="form-group">
                            <!-- Label  -->
                            <label>
                                الكلمات المفتاحية
                            </label>
                            <!-- Text -->
                            <small class="form-text text-muted">
                                تحسن الكلمات المفتاحية من ظهورك في محركات قوقل
                            </small>
                            <!-- Input -->
                            <textarea class="form-control" name="keywords" placeholder="تطبيقات, العاب, برامج, بلس">{{ old('keywords', $settings->keywords) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <!-- group name -->
                        <div class="form-group">
                            <!-- Label  -->
                            <label>
                                شروط الطلبات
                            </label>
                            <!-- Text -->
                            <small class="form-text text-muted">
                                سيظهر للمشتركين او الزوار
                            </small>
                            <!-- Input -->
                            <textarea id="editor" name="conditions_order">
                                {{ old('conditions_order', $settings->conditions_order) }}
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Card -->
        <div class="card">
            <div class="card-header">
               خيارات المتجر
            </div>
            <div class="card-body">
                <div class="row" style="direction: rtl">

                    <div class="col-md-12">
                        <!-- group name -->
                        <div class="form-group">
                            <!-- Label  -->
                            <label>
                                حالة المتجر
                            </label>
                            <!-- Text -->
                            <small class="form-text text-muted">
                                في حال تم ايقاف المتجر ستظهر رسالة ان المتجر مغلق
                            </small>
                            <!-- Input -->
                            <select class="custom-select" data-toggle="select" name="status_store">
                                <option value="1" {{ old('status_store', $settings->status_store) == 1 ? 'selected' : '' }}>متاح لزوار</option>
                                <option value="0" {{ old('status_store', $settings->status_store) == 0 ? 'selected' : '' }}>ايقاف المتجر</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <!-- group name -->
                        <div class="form-group">
                            <!-- Label  -->
                            <label>
                                حالة الطلبات الجديد
                            </label>
                            <!-- Text -->
                            <small class="form-text text-muted">
                                في حال تم ايقاف الطلبات لن يتمكن احد من تقديم طلب جديد
                            </small>
                            <!-- Input -->
                            <select class="custom-select" data-toggle="select" name="status_orders">
                                <option value="1" {{ old('status_orders', $settings->status_orders) == 1 ? 'selected' : '' }}>متاح</option>
                                <option value="0" {{ old('status_orders', $settings->status_orders) == 1 ? 'selected' : '' }}>ايقاف</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <!-- group name -->
                        <div class="form-group">
                            <!-- Label  -->
                            <label>
                               قيمة الاشتراك
                            </label>
                            <!-- Text -->
                            <small class="form-text text-muted">
                               قمية الاشتراك تحدد لك مدخولك في احصائيات الموقع
                            </small>
                            <!-- Input -->
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control form-control-prepended"
                                       value="{{ old('price_order', $settings->price_order) }}"
                                       name="price_order"
                                >
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-pen"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <!-- Card -->
                <div class="card">
                    <div class="card-header">
                        بياناتك الشخصية
                    </div>
                    <div class="card-body">
                        <div class="row" style="direction: rtl">
                            <div class="col-md-12">
                                <!-- group name -->
                                <div class="form-group">
                                    <!-- Label  -->
                                    <label>
                                        حسابك في تويتر
                                    </label>
                                    <!-- Text -->
                                    <small class="form-text text-muted">
                                        سيظهر حسابك في التطبيق و المتجر
                                    </small>
                                    <!-- Input -->
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control form-control-prepended"
                                               value="{{ old('twitter_account', $settings->twitter_account) }}"
                                               name="twitter_account"
                                        >
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-pen"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <!-- group name -->
                                <div class="form-group">
                                    <!-- Label  -->
                                    <label>
                                        حسابك في سناب شات
                                    </label>
                                    <!-- Text -->
                                    <small class="form-text text-muted">
                                        سيظهر حسابك في التطبيق و المتجر
                                    </small>
                                    <!-- Input -->
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control form-control-prepended"
                                               value="{{ old('snapchat_account', $settings->snapchat_account) }}"
                                               name="snapchat_account"
                                        >
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-pen"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <!-- group name -->
                                <div class="form-group">
                                    <!-- Label  -->
                                    <label>
                                        حسابك في تليجرام
                                    </label>
                                    <!-- Text -->
                                    <small class="form-text text-muted">
                                        سيظهر حسابك في التطبيق و المتجر
                                    </small>
                                    <!-- Input -->
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control form-control-prepended"
                                               value="{{ old('telegram_account', $settings->telegram_account) }}"
                                               name="telegram_account"
                                        >
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-pen"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <!-- group name -->
                                <div class="form-group">
                                    <!-- Label  -->
                                    <label>
                                        حسابك في الواتس اب
                                    </label>
                                    <!-- Text -->
                                    <small class="form-text text-muted">
                                        سيظهر حسابك في التطبيق و المتجر
                                    </small>
                                    <!-- Input -->
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control form-control-prepended"
                                               value="{{ old('whatsapp_account', $settings->whatsapp_account) }}"
                                               name="whatsapp_account"
                                        >
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-pen"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card">
                    <div class="card-header">
                        بيانات الدخول
                    </div>
                    <div class="card-body">
                        <div class="row" style="direction: rtl">
                            <div class="col-md-12">
                                <!-- group name -->
                                <div class="form-group">
                                    <!-- Label  -->
                                    <label>
                                       البريد الالكتروني
                                    </label>
                                    <!-- Text -->
                                    <small class="form-text text-muted">
                                       البريد الالكتروني لتسجيل الدخول للوحة التحكم
                                    </small>
                                    <!-- Input -->
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control form-control-prepended"
                                               value="{{ old('email', $user->email) }}"
                                               name="email"
                                        >
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <!-- group name -->
                                <div class="form-group">
                                    <!-- Label  -->
                                    <label>
                                         كلمة المرور
                                    </label>
                                    <!-- Text -->
                                    <small class="form-text text-muted">
                                        كلمة المرور لتسجيل الدخول للوحة التحكم
                                    </small>
                                    <!-- Input -->
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control form-control-prepended"
                                               value="{{ old('password') }}"
                                               name="password"
                                        >
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-key"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        اعدادات OneSignal--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="row" style="direction: rtl">--}}
{{--                            <div class="col-md-12">--}}
{{--                                <!-- group name -->--}}
{{--                                <div class="form-group">--}}
{{--                                    <!-- Label  -->--}}
{{--                                    <label>--}}
{{--                                       APP_KEY--}}
{{--                                    </label>--}}
{{--                                    <!-- Text -->--}}
{{--                                    <small class="form-text text-muted">--}}
{{--                                        يمكنك العثور عليه في حسابك علي موقع OneSignal--}}
{{--                                    </small>--}}
{{--                                    <!-- Input -->--}}
{{--                                    <div class="input-group input-group-merge">--}}
{{--                                        <input type="text" class="form-control form-control-prepended"--}}
{{--                                               value="{{ old('one_signal_app_key', $settings->one_signal_app_key) }}"--}}
{{--                                               name="one_signal_app_key"--}}
{{--                                        >--}}
{{--                                        <div class="input-group-prepend">--}}
{{--                                            <div class="input-group-text">--}}
{{--                                                <i class="fas fa-pen"></i>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-12">--}}
{{--                                <!-- group name -->--}}
{{--                                <div class="form-group">--}}
{{--                                    <!-- Label  -->--}}
{{--                                    <label>--}}
{{--                                         APP_ID--}}
{{--                                    </label>--}}
{{--                                    <!-- Text -->--}}
{{--                                    <small class="form-text text-muted">--}}
{{--                                        يمكنك العثور عليه في حسابك علي موقع OneSignalس--}}
{{--                                    </small>--}}
{{--                                    <!-- Input -->--}}
{{--                                    <div class="input-group input-group-merge">--}}
{{--                                        <input type="text" class="form-control form-control-prepended"--}}
{{--                                               value="{{ old('one_signal_app_id', $settings->one_signal_app_id) }}"--}}
{{--                                               name="one_signal_app_id"--}}
{{--                                        >--}}
{{--                                        <div class="input-group-prepend">--}}
{{--                                            <div class="input-group-text">--}}
{{--                                                <i class="fas fa-pen"></i>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                </div>--}}

                <div class="col-lg-12 col-md-12">
                    <!-- Divider -->
                    <hr class="mt-4 mb-5">
                    <!-- Buttons -->
                    <button type="submit" class="btn btn-block btn-primary">
                        حفظ التعديلات
                    </button>
                </div>
                <br>
                <br>
                <br>
                </form>

            </div>


@endsection





@section('javascript')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#editor',
            skin: 'bootstrap',
            plugins: 'lists, link, image, media',
            toolbar: 'h1 h2 bold italic strikethrough blockquote bullist numlist backcolor | link image media | removeformat help',
            menubar: false
        });

        $(document).ready(function(){
            $('.upload-single-file input').change(function (e) {
                $('.upload-single-file p').text(" ملف واحد محدد ("+ e.target.files[0].name +")");
            });
        });
    </script>
@endsection
