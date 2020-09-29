@extends('dashboard.layouts.app')

@section('title',' تعديل - '.$group->name.'')

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
                        تعديل المجموعة
                    </h6>

                    <!-- Title -->
                    <h1 class="header-title">
                        {{ $group->name }}
                    </h1>

                </div>

            </div> <!-- / .row -->
            <div class="row">
                <div class="col-12">

                    <ul class="nav nav-tabs header-tabs" id="myTabMulit" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-center {{ old('page_id') == 'appleAccount' ? '' : 'active' }} " id="information-tab" data-toggle="tab" href="#information" role="tab" aria-controls="information" aria-selected="{{ old('page_id') == 'appleAccount' ? 'false' : 'true' }}">
                               المعلومات
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center" id="compensation-tab" data-toggle="tab" href="#compensation" role="tab" aria-controls="compensation" aria-selected="false">
                                التعويض
                            </a>
                        </li>
                        <li class="nav-item">
                            <a  class="nav-link text-center {{ old('page_id') == 'appleAccount' ? 'active' : '' }}" id="appleAccount-tab" data-toggle="tab" href="#appleAccount" role="tab" aria-controls="appleAccount" aria-selected="{{ old('page_id') == 'appleAccount' ? 'true' : 'false' }}">
                                حساب المطورين
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>




        <div class="tab-content" id="myTabContent">


            <!=========== Information Group
            =================================>
            <div class="tab-pane fade show active" id="information" role="tabpanel" aria-labelledby="information-tab">

                <div class="tabBody">
                    <form class="mb-4" action="{{ route('dashboard.groups.update', $group->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-9">

                                <input name="page_id" value="information" hidden>
                                <!-- group name -->
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
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control form-control-prepended @error('name') is-invalid @enderror"
                                               placeholder="مثال: مجموعة 35"
                                               name="name"
                                               value="{{ old('name', $group->name) }}"
                                        >
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-pen"></i>
                                            </div>
                                        </div>
                                        @error('name')
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
                                        رقم الشهادة
                                    </label>
                                    <!-- Text -->
                                    <small class="form-text text-muted">
                                        رقم الشهادة  ثابت ولايمكن تعديلة
                                    </small>

                                    <!-- Input -->
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control form-control-prepended "
                                               value="{{ $group->team_id }}"
                                               disabled
                                        >
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-hashtag"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <!-- group name -->
                                <div class="form-group">
                                    <!-- Label  -->
                                    <label>
                                        مجلد المجموعة
                                    </label>
                                    <!-- Text -->
                                    <small class="form-text text-muted">
                                        مجلد المجموعة ثابت ولايمكن تعديلة
                                    </small>

                                    <!-- Input -->
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control form-control-prepended "
                                               value="{{ $group->folder }}"
                                               disabled
                                        >
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-folder"></i>
                                            </div>
                                        </div>

                                    </div>

                                </div>


                                <!-- Divider -->
                                <hr class="mt-4 mb-5">


                                <!-- upload files -->
                                <div class="form-group">

                                    <!-- Label -->
                                    <label class="mb-1">
                                        رفع الملف .p12 جديد
                                    </label>

                                    <!-- Text -->
                                    <small class="form-text text-muted">
                                        الرجاء رفع ملف .p12 بعد استخراجه من سلسلة المفاتيح
                                    </small>

                                    <!-- Card -->
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="upload-single-file">
                                                <input type="file" accept="application/x-pkcs12" name="file_p12">
                                                <p class="message-upload-file">قم بضغط هنا لرفع ملف p12 </p>
                                            </div>

                                            @error('file_p12')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-3">
                                <!-- upload files -->
                                <div class="form-group">

                                    <!-- Label -->
                                    <label class="mb-1">
                                       حالة المجموعة
                                    </label>

                                    <!-- Text -->
                                    <small class="form-text text-muted">
                                     في حال اغلاق المجموعة لن يتمكن اي مستخدم من تنزيل المتجر او تحميل تطبيق او توقيع تطبيق
                                    </small>

                                    <!-- Card -->
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="status"
                                            @if(old('status', $group->status == 1))
                                               checked
                                            @endif
                                        >
                                        <label class="custom-control-label" for="customSwitch1"></label>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12">
                                <!-- Buttons -->
                                <button type="submit" class="btn btn-block btn-primary">
                                  حفظ التعديل
                                </button>
                            </div>
                        </div>


                    </form>
                </div>

            </div>



            <!=========== Compensation Group
            =================================>
            <div class="tab-pane fade" id="compensation" role="tabpanel" aria-labelledby="compensation-tab" style="margin-top: 30px">
                <div class="card" data-list='{"valueNames": ["customer-id", "customer-name", "customer-udid"]}'>
                    <div class="card-header">
                        <!-- Search -->
                        <form>
                            <div class="input-group input-group-flush">
                                <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fe fe-search"></i>
                      </span>
                                </div>
                                <input class="form-control list-search search-table" style="margin-right: 5px" type="search" placeholder="البحث عن مجموعة">
                            </div>
                        </form>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-white dropdown-toggle" type="button" id="bulkActionDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                اجراءات التعويض
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bulkActionDropdown">
                                <a class="dropdown-item" type="button" data-toggle="modal" data-target="#selectGroupAll">تعويض كل المشتركين</a>
                                <a class="dropdown-item" type="button" data-toggle="modal" data-target="#selectGroupSpi">تعويض المشتركين المستحقين فقط</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-nowrap card-table table-live-data">
                            <thead>
                            <tr>
                                <th>
                                    <a href="#" class="text-muted list-sort" data-sort="customer-id">
                                        رقم المشترك
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-muted list-sort" data-sort="customer-name">
                                        اسم المشترك
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-muted list-sort" data-sort="customer-udid">
                                        UDID
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-muted list-sort" >
                                        رقم الجوال
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-muted list-sort" >
                                        بداية الاشتراك
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-muted list-sort">
                                       حالة التعويض
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-muted list-sort">
                                        نوع الجهاز
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-muted list-sort">
                                       حالة المشترك
                                    </a>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @foreach($getCustomers as $customer)
                                <tr>
                                    <td class="customer-id">
                                        #{{ $customer['id'] }}
                                    </td>
                                    <td class="customer-name">
                                        {{ $customer['full_name'] == '' ? '—' : $customer['full_name'] }}
                                    </td>
                                    <td class="customer-udid">
                                        <div class="badge badge-soft-secondary">
                                            {{ $customer['udid'] }}
                                        </div>
                                    </td>
                                    <td class="orders-total">
                                        {{ $customer['phone_number']  == '' ? '—' : $customer['phone_number'] }}
                                    </td>
                                    <td class="orders-status">
                                        {{ $customer->getAddedDevice() }}
                                    </td>
                                    <td class="orders-status">
                                        <div class="badge badge-soft-{{ $customer->getStatusCompensation()['className'] }}">
                                            {{ $customer->getStatusCompensation()['status'] }}
                                        </div>
                                    </td>
                                    <td class="orders-method">
                                        {{ $customer['device_model']  == '' ? '—' : $customer['device_model'] }}
                                    </td>
                                    <td class="orders-status">
                                        <!-- Badge -->
                                        <div class="badge badge-soft-{{ $customer->getStatus()['className'] }}">
                                            {{ $customer->getStatus()['status'] }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <!=========== Apple Account
            =================================>
            <div class="tab-pane fade" id="appleAccount" role="tabpanel" aria-labelledby="appleAccount-tab">

                <div class="tabBody">

                    <form action="{{ route('dashboard.groups.update', $group->id) }}" method="post">
                        @csrf
                        @method('put')
                        <input name="page_id" value="appleAccount" hidden>


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
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control form-control-prepended @error('apple_email') is-invalid @enderror"
                                               placeholder="مثال: apple@email.com"
                                               name="apple_email"
                                               value="{{ old('apple_email', \App\Helpers\EncryptHelper::Decrypt($getAppleAccount[0]->apple_email)) }}"
                                        >
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                        </div>

                                        @error('apple_email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror


                                    </div>
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
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control form-control-prepended @error('apple_password') is-invalid @enderror"
                                               placeholder="**********"
                                               name="apple_password"
                                               value="{{ old('apple_password') }}"
                                        >
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-lock-alt"></i>
                                            </div>
                                        </div>
                                        @error('apple_password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
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
                                            <input type="radio" name="send_code" id="option1" value="1" checked=""> <i class="fe fe-monitor"></i> جهاز الماك
                                        </label>
                                        <label class="btn btn-white">
                                            <input type="radio" name="send_code" id="option2" value="2"> <i class="fe fe-smartphone"></i> رسالة sms
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div> <!-- / .row -->

                        <div class="col-md-12">
                            <!-- Buttons -->
                            <button type="submit" class="btn btn-block btn-primary">
                               تفعيل الحساب
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>


    </div>

    <!-- Modal -->
    <div class="modal fade" id="selectGroupSpi" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">تعويض المشتركين المستحقين فقط - {{ $group->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <!-- Label  -->
                        <label>
                            حدد مجموعة التعويض الجديد
                        </label>
                        <!-- Text -->
                        <small class="form-text text-muted">
                            الرجاء اختيار المجموعة الجديدة لنقل المشتركين المستحقين التعويض لها.
                        </small>

                        <!-- Input -->
                        <select class="custom-select" data-toggle="select" id="compensationOfSpecificCustomers">
                            @foreach($getAllGroup as $groupsData)
                                <option value="{{ $groupsData['id'] }}">{{ $groupsData['name'] }}</option>
                            @endforeach
                        </select>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    <button type="button" class="btn btn-primary" id="moveCustomersToAntherGroup" data-id="{{ $group->id }}" >تطبيق التعويض</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="selectGroupAll" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"> تعويض كل المشتركين - {{ $group->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <!-- Label  -->
                        <label>
                            حدد مجموعة التعويض الجديد
                        </label>
                        <!-- Text -->
                        <small class="form-text text-muted">
                            الرجاء اختيار المجموعة الجديدة لنقل كل المشتركين.
                        </small>

                        <!-- Input -->
                        <select class="custom-select" data-toggle="select" id="compensationOfAllCustomers">
                            @foreach($getAllGroup as $groupsData)
                                <option value="{{ $groupsData['id'] }}">{{ $groupsData['name'] }}</option>
                            @endforeach
                        </select>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    <button type="button" class="btn btn-primary" id="moveAllCustomersToAntherGroup" data-id="{{ $group->id }}" >تطبيق التعويض</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>

        // Setup Ajax
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $(document).ready(function(){
            $('.upload-single-file input').change(function (e) {
                $('.upload-single-file p').text(" ملف واحد محدد ("+ e.target.files[0].name +")");
            });


            $('#moveCustomersToAntherGroup').click(function () {
                let group_id = $(this).attr('data-id');
                let new_group_id = $('#compensationOfSpecificCustomers').val();

                Swal.fire({
                    title: 'هل انت متاكد؟',
                    text: "سيتم نقل المشتركين المستحقين الى مجموعة التعويض الجديدة",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'نعم قم بالتعويض!',
                    cancelButtonText: 'اغلاق'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type:'post',
                            url: "{{ route('dashboard.customers.ajax.compensationOfSpecificCustomers') }}",
                            data: {group_id:  group_id,new_group_id:  new_group_id},
                            success: function( msg ) {
                                console.log(msg);
                                Swal.fire(
                                    'بنجاح!',
                                    'تم تعويض المشتركين بنجاح.',
                                    'success'
                                )
                                $('#selectGroupSpi').modal('hide')
                            }
                        });
                    }
                })


            });
            $('#moveAllCustomersToAntherGroup').click(function () {
                let group_id = $(this).attr('data-id');
                let new_group_id = $('#compensationOfAllCustomers').val();

                Swal.fire({
                    title: 'هل انت متاكد؟',
                    text: "سيتم نقل كل المشتركين الى مجموعة التعويض الجديدة",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'نعم قم بالتعويض!',
                    cancelButtonText: 'اغلاق'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type:'post',
                            url: "{{ route('dashboard.customers.ajax.compensationOfAllCustomers') }}",
                            data: {group_id:  group_id,new_group_id:  new_group_id},
                            success: function( msg ) {
                                console.log(msg);
                                Swal.fire(
                                    'بنجاح!',
                                    'تم تعويض المشتركين بنجاح.',
                                    'success'
                                )
                                $('#selectGroupAll').modal('hide')
                            }
                        });
                    }
                })


            });
        });
    </script>
@endsection
