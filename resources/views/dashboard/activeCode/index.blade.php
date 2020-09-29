@extends('dashboard.layouts.app')

@section('title','اكواد التفعيل')

@section('content')
    <div class="container-fluid">
        <div class="header-body ">
            <div class="row align-items-start">
                <div class="col-auto">

                    <!-- Button -->
                    <a href="#" class="btn btn-primary lift" type="button" data-toggle="modal" data-target="#createActiveCodeModel">
                        إنشاء اكواد جديدة
                    </a>
                </div>
                <div class="col text-right">
                    <!-- Pretitle -->
                    <h6 class="header-pretitle">
                        لوحة التحكم
                    </h6>

                    <!-- Title -->
                    <h1 class="header-title">
                        اكواد التفعيل
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
        <div class="card" data-list='{"valueNames": ["id", "code", "customer"]}'>
            <div class="card-header">
                اكواد التفعيل التلقائي
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-nowrap card-table table-live-data">
                    <thead>
                    <tr>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="id">
                               #
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="code">
                                كود التفعيل
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="customer">
                               الجهاز المسجل
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort">
                                حالة الكود
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort">
                                تاريخ التسجيل
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
                    @foreach($activeCodes as $activeCode)
                        <tr>
                            <td class="id">
                                #{{ $activeCode['id'] }}
                            </td>
                            <td class="code">
                                {{ $activeCode['code'] }}
                            </td>
                            <td class="customer">
                                {{ $activeCode['customer_id'] == '' ? '—' : $activeCode->customer->udid }}
                            </td>
                            <td class="customer">
                                {!! $activeCode['customer_id']  == '' ?
                                    '<div class="badge badge-soft-success">غير مستخدم</div>'
                                    :
                                    '<div class="badge badge-soft-danger">مستخدم</div>'
                                !!}
                            </td>
                            <td class="">
                                {{ $activeCode->getLastUpdate() }}
                            </td>
                            <td class="text-right">
                                <!-- Dropdown -->
                                <div class="dropdown">
                                    <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" onclick="deleteActiveCode({{ $activeCode['id'] }})">
                                            حذف
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
            {{ $activeCodes->links() }}
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="createActiveCodeModel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">إنشاء اكواد تفعيل جديدة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <!-- Label  -->
                        <label>
                            حدد عدد اكواد التفعيل
                        </label>
                        <!-- Text -->
                        <small class="form-text text-muted">
                           الرجاء التاكد من وجود توافق بين عدد الاكواد الجديدة و عدد الاجهزة المتاحة في كل شهادة.
                        </small>

                        <!-- Input -->
                        <select class="custom-select" data-toggle="select" id="numActiveCode">
                           @for($x = 1; $x <= 100; $x++)
                               <option value="{{ $x }}">{{ $x }}</option>
                            @endfor
                        </select>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    <button type="button" class="btn btn-primary" id="createNewActiveCode">إنشاء</button>
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

        $(document).on('click', '#createNewActiveCode', function(){
            let numActiveCode = $('#numActiveCode').val();

            $.ajax({
                type:'post',
                url: "{{ route('dashboard.active.code.create') }}",
                data: {num_active_code:  numActiveCode},
                success: function( response ) {

                    console.log(response)
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
                        setTimeout(function(){
                            window.location = "{{ route('dashboard.active.code.index') }}";
                        }, 1500);
                    }
                }
            });

        });



        // Delete Function
        function deleteActiveCode(active_id)
        {
            Swal.fire({
                title: 'هل انت متاكد؟',
                text: "هل انت متاكد من حذف كود التفعيل، لن تتمكن من ارجاع الكود مرة اخرى",
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
                        url: "{{ route('dashboard.active.code.ajax.delete') }}",
                        data: {active_id:  active_id},
                        success: function( response ) {
                            Swal.fire(
                                'بنجاح!',
                                response['message'],
                                'success'
                            )
                            setTimeout(function(){
                                window.location = "{{ route('dashboard.active.code.index') }}";
                            }, 1500);
                        }
                    });
                }
            })
        }
    </script>
@endsection




