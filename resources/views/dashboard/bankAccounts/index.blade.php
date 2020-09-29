@extends('dashboard.layouts.app')

@section('title','طرق الدفع')

@section('content')
    <div class="container-fluid">

        <div class="header-body ">
            <div class="row align-items-start">
                <div class="col-auto">

                    <!-- Button -->
                    <a href="{{ route('dashboard.accounts.create') }}" class="btn btn-primary lift" >
                        اضافة حساب بنكي
                    </a>
                </div>
                <div class="col text-right">

                    <!-- Pretitle -->
                    <h6 class="header-pretitle">
                        لوحة التحكم
                    </h6>

                    <!-- Title -->
                    <h1 class="header-title">
                        طرق الدفع
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
        <div class="card" data-list='{"valueNames": ["full_name", "phone_number", "udid"]}'>
            <div class="card-header">
              الحسابات البنكية
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-nowrap card-table table-live-data">
                    <thead>
                    <tr>
                        <th>
                            <a href="#" class="text-muted list-sort" >
                                #
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="customer-name">
                              اسم البنك
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="customer-name">
                                شعار البنك
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="customer-udid">
                                اسم صاحب الحساب
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" >
                                رقم الحساب
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" >
                                IBAN
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort">
                               اخر تحديث
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
                    @foreach($banks as $bank)
                        <tr>
                            <td class="customer-id">
                                #{{ $bank['id'] }}
                            </td>
                            <td class="customer-name">
                                {{ $bank['bank_name'] }}
                            </td>
                            <td class="customer-udid">
                                <img src="{{ asset('storage/images/banks/'.$bank['bank_image'].'') }}" class="bankImage">
                            </td>
                            <td class="orders-total">
                                {{ $bank['owner_name'] }}
                            </td>
                            <td class="orders-total">
                                {{ $bank['account_number'] }}
                            </td>
                            <td class="orders-status">
                                {{ $bank['iban'] }}
                            </td>
                            <td class="orders-status">
                                    {{ $bank->getLastUpdate() }}
                            </td>
                            <td class="text-right">
                                <!-- Dropdown -->
                                <div class="dropdown">
                                    <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" onclick="deleteBank({{ $bank['id'] }})">
                                            حذف
                                        </a>
                                        <a class="dropdown-item" href="{{ route('dashboard.accounts.edit', $bank['id']) }}">
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
        function deleteBank(bank_id)
        {
            Swal.fire({
                title: 'هل انت متاكد؟',
                text: "هل انت متاكد من حذف حسابك البنكي، لن تتمكن من ارجاع الحساب مرة اخرى",
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
                        url: "{{ route('dashboard.accounts.ajax.delete') }}",
                        data: {bank_id:  bank_id},
                        success: function( response ) {
                            Swal.fire(
                                'بنجاح!',
                                response['message'],
                                'success'
                            )
                            setTimeout(function(){
                                window.location = "{{ route('dashboard.accounts.index') }}";
                            }, 1500);
                        }
                    });
                }
            })
        }
    </script>
@endsection




