@extends('dashboard.layouts.app')

@section('title','الطلبات')

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
                        الطلبات
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
                        <input class="form-control list-search search-table" style="margin-right: 5px" type="search" placeholder="البحث عن طلب">
                    </div>
                </form>

            </div>
            <div class="table-responsive">
                <table class="table table-sm table-nowrap card-table table-live-data">
                    <thead>
                    <tr>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="order_id">
                                رقم الطلب
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="full_name">
                                اسم صاحب الطلب
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="phone_number">
                                رقم الجوال
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="udid">
                                UDID
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" >
                                نوع الجهاز
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" >
                                كود الاشتراك
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort">
                                حالة الطلب
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort">
                                تاريخ الطلب
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted ">
                                الاجراءات
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="list">
                    @foreach($orders as $order)
                        <tr>
                            <td class="order_id">
                                #{{ $order['id'] }}
                            </td>
                            <td class="full_name">
                                {{ $order['full_name'] }}
                            </td>
                            <td class="phone_number">
                                <a href="http://wa.me/{{ $order['phone_number'] }}" target="_blank" class="wp-link">{{ $order['phone_number'] }}</a>
                            </td>
                            <td class="udid">
                                {{ $order['udid'] }}
                            </td>
                            <td class="">
                                {{ $order['device_model'] }}
                            </td>
                            <td class="">
                                {{ $order['register_coupon'] != '' ? $order['register_coupon'] : '—' }}
                            </td>
                            <td class="">
                                <!-- Badge -->
                                <div class="badge badge-soft-{{ $order->getStatus()['className'] }}">
                                    {{ $order->getStatus()['status'] }}
                                </div>
                            </td>
                            <td class="">
                                {{ $order->getLastUpdate() }}
                            </td>
                            <td class="text-right">
                                <!-- Dropdown -->
                                <div class="dropdown">
                                    <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" onclick="deleteOrder({{ $order['id'] }})">
                                            حذف
                                        </a>
                                        <a class="active_new_customer dropdown-item" data-id="{{ $order['id'] }}" data-name="{{ $order['full_name'] }}">
                                            تفعيل
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
            {{ $orders->links() }}
        </div>

    </div>

    <div class="modal fade" id="selectGroup" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">تفعيل - </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <!-- Label  -->
                        <label>
                          حدد المجموعة
                        </label>
                        <!-- Text -->
                        <small class="form-text text-muted">
                            لتفعيل المشترك الجديد واضافة لحساب المطورين عليك تحديد مجموعة للمشترك.
                        </small>

                        <!-- Input -->
                        <select class="custom-select" data-toggle="select" id="select_group_id">
                            @foreach($getGroups as $groupsData)
                                <option value="{{ $groupsData['id'] }}">{{ $groupsData['name'] }}</option>
                            @endforeach
                        </select>
                        <input name="customer_id" id="active_customer_id" value="" hidden/>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    <button type="button" class="btn btn-primary" id="activeNewCustomer" >تفعيل المشترك</button>
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

        $(document).on('click', '.active_new_customer', function(){
            let customer_id = $(this).attr('data-id');
            let customer_name = $(this).attr('data-name');
            $('h5.modal-title').text('تفعيل - ' + customer_name);
            $('#active_customer_id').val(customer_id);
            $('#selectGroup').modal('show');
        });

        $(document).on('click', '#activeNewCustomer', function(){
            let customer_id = $('#active_customer_id').val();
            let group_id = $('#select_group_id').val();
            console.log(customer_id, group_id);

            $.ajax({
                type:'post',
                url: "{{ route('dashboard.orders.ajax.active') }}",
                data: {customer_id:  customer_id, group_id: group_id},
                success: function( response ) {

                    if(response['success'] == false)
                    {
                        Swal.fire(
                            'حدث خطاء!',
                            response['message'],
                            'error'
                        )
                    }else{
                        Swal.fire(
                            'بنجاح!',
                            response['message'],
                            'success'
                        )
                    }
                    console.log(response);
                }
            });

        });



        // Delete Function
        function deleteOrder(order_id)
        {
            Swal.fire({
                title: 'هل انت متاكد؟',
                text: "هل انت متاكد من حذف الطلب، لن تتمكن من ارجاع الطلب مرة اخرى",
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
                        url: "{{ route('dashboard.orders.ajax.delete') }}",
                        data: {order_id:  order_id},
                        success: function( response ) {
                            Swal.fire(
                                'بنجاح!',
                                response['message'],
                                'success'
                            )
                            setTimeout(function(){
                                window.location = "{{ route('dashboard.orders.index') }}";
                            }, 1500);
                        }
                    });
                }
            })
        }
    </script>
@endsection




