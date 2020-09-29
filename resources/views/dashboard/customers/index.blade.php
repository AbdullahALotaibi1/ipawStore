@extends('dashboard.layouts.app')

@section('title','المشتركين')

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
                        المشتركين
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
                <!-- Search -->
                <form>
                    <div class="input-group input-group-flush">
                        <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fe fe-search"></i>
                      </span>
                        </div>
                        <input class="form-control list-search search-table" style="margin-right: 5px" type="search" placeholder="البحث عن مشترك">
                    </div>
                </form>

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
                               المجموعة
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
                        <th>
                            <a href="#" class="text-muted list-sort">
                                الاجراءات
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="list">
                    @foreach($customers as $customer)
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
                            <td class="orders-total">
                                {{ $customer->groups()->first()->name }}
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
                            <td class="text-right">
                                <!-- Dropdown -->
                                <div class="dropdown">
                                    <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" onclick="deleteCustomer({{ $customer['id'] }})">
                                            حذف
                                        </a>
                                        <a class="dropdown-item" href="{{ route('dashboard.customers.edit', $customer['id']) }}">
                                            تعديل
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>

        </div>
        <div class="pagination-class">
            {{ $customers->links() }}
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

        // Delete Function
        function deleteCustomer(customer_id)
        {
            Swal.fire({
                title: 'هل انت متاكد؟',
                text: "هل انت متاكد من حذف المشترك، لن تتمكن من ارجاع المشترك مرة اخرى",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#dd3333',
                confirmButtonText: 'نعم قم بالحذف!',
                cancelButtonText: 'اغلاق'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type:'post',
                        url: "{{ route('dashboard.customers.ajax.delete') }}",
                        data: {customer_id:  customer_id},
                        success: function( response ) {
                            Swal.fire(
                                'بنجاح!',
                                response['message'],
                                'success'
                            )
                            setTimeout(function(){
                                window.location = "{{ route('dashboard.customers.index') }}";
                            }, 1500);
                        }
                    });
                }
            })
        }
    </script>
@endsection




