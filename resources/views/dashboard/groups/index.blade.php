@extends('dashboard.layouts.app')

@section('title','المجموعات')

@section('content')
    <div class="container-fluid">
        <div class="header-body ">
        <div class="row align-items-start">
            <div class="col-auto">

                <!-- Button -->
                <a href="{{ route('dashboard.groups.create') }}" class="btn btn-primary lift" >
                    اضافة مجموعة
                </a>
            </div>
            <div class="col text-right">

                <!-- Pretitle -->
                <h6 class="header-pretitle">
                    لوحة التحكم
                </h6>

                <!-- Title -->
                <h1 class="header-title">
                    المجموعات
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
            <div class="col-12 col-lg-2">

                <!-- Card -->
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">

                                <!-- Title -->
                                <h6 class="text-uppercase text-muted mb-2">
                                    عدد المجموعات
                                </h6>

                                <!-- Heading -->
                                <span class="h2 mb-0">
                                    {{ $statistics['count_group'] }}
                                </span>

                            </div>
                            <div class="col-auto">

                                <!-- Icon -->
                                <i class="fas fa-window-restore text-muted mb-0 h2"></i>

                            </div>
                        </div> <!-- / .row -->

                    </div>
                </div>

            </div>
            <div class="col-12 col-lg-2">

                <!-- Card -->
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">

                                <!-- Title -->
                                <h6 class="text-uppercase text-muted mb-2">
                                    المجموعات المتاحة
                                </h6>
                                <!-- Heading -->
                                <span class="h2 mb-0">
                                    {{ $statistics['active_group'] }}
                                </span>

                            </div>
                            <div class="col-auto">

                                <!-- Icon -->
                                <i class="fas fa-check-square text-muted mb-0 h2"></i>
                            </div>
                        </div> <!-- / .row -->
                    </div>
                </div>

            </div>
            <div class="col-12 col-lg-2">

                <!-- Card -->
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">

                                <!-- Title -->
                                <h6 class="text-uppercase text-muted mb-2">
                                    المجموعات الممتلئة
                                </h6>

                                <!-- Heading -->
                                <span class="h2 mb-0">
                                    {{ $statistics['full_group'] }}
                        </span>

                            </div>
                            <div class="col-auto">

                                <!-- Icon -->
                                <i class="fas fa-exclamation-square text-muted mb-0 h2"></i>

                            </div>
                        </div> <!-- / .row -->

                    </div>
                </div>

            </div>
            <div class="col-12 col-lg-2">

                <!-- Card -->
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">

                                <!-- Title -->
                                <h6 class="text-uppercase text-muted mb-2">
                                    المجموعات المغلقة
                                </h6>

                                <!-- Heading -->
                                <span class="h2 mb-0">
                                    {{ $statistics['disabled_group'] }}
                        </span>

                            </div>
                            <div class="col-auto">

                                <!-- Icon -->
                                <i class="fas fa-times-square text-muted mb-0 h2"></i>

                            </div>
                        </div> <!-- / .row -->

                    </div>
                </div>

            </div>
            <div class="col-12 col-lg-2">

                <!-- Card -->
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">

                                <!-- Title -->
                                <h6 class="text-uppercase text-muted mb-2">
                                    المجموعات المنتهية
                                </h6>

                                <!-- Heading -->
                                <span class="h2 mb-0">
                                    {{ $statistics['expired_group'] }}
                                </span>

                            </div>
                            <div class="col-auto">

                                <!-- Icon -->
                                <i class="fas fa-calendar-alt text-muted mb-0 h2"></i>

                            </div>
                        </div> <!-- / .row -->

                    </div>
                </div>

            </div>
        </div>


        <! ============ Table
         =======================>

        <!-- Card -->
        <div class="card" data-list='{"valueNames": ["group-id", "group-name", "team-id"]}'>
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

            </div>
            <div class="table-responsive">
                <table class="table table-sm table-nowrap card-table table-live-data">
                    <thead>
                    <tr>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="group-id">
                                رقم المجموعة
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="group-name">
                                اسم المجموعة
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="team-id">
                                Team ID
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" >
                                عدد المشتركين
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" >
                                مدة صلاحية الشهادة
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort">
                                حالة المجموعة
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort">
                                اخر تحديث
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
                    @foreach($groups as $group)
                        <tr>
                            <td class="orders-order">
                                #{{ $group['id'] }}
                            </td>
                            <td class="orders-product">
                                {{ $group['name'] }}
                            </td>
                            <td class="orders-date">
                                {{ $group['team_id'] }}
                            </td>
                            <td class="orders-total">
                                {{ $group->customers()->count() }}
                            </td>
                            <td class="orders-status">
                                {{ $group->getDateExpires() }}
                            </td>
                            <td class="orders-method">
                                <!-- Badge -->
                                <div class="badge badge-soft-{{ $group->getStatus()['className'] }}">
                                    {{ $group->getStatus()['status'] }}
                                </div>
                            </td>
                            <td class="orders-status">
                                {{ $group->getLastUpdate() }}
                            </td>
                            <td class="text-right">
                                <!-- Dropdown -->
                                <div class="dropdown">
                                    <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" onclick="deleteGroup({{ $group['id'] }})">
                                            حذف
                                        </a>
                                        <a href="{{ route('dashboard.groups.edit', $group['id']) }}" class="dropdown-item">
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
            {{ $groups->links() }}
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

        // Delete Group Function
        function deleteGroup(group_id)
        {
            Swal.fire({
                title: 'هل انت متاكد؟',
                text: "هل انت متاكد من حذف المجموعة، سيتم حذف كل المشتركين والتطبيقات والشهادات",
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
                        url: "{{ route('dashboard.groups.ajax.delete') }}",
                        data: {group_id:  group_id},
                        success: function( msg ) {
                            Swal.fire(
                                'بنجاح!',
                                'تم حذف المجموعة بنجاح.',
                                'success'
                            )
                            setTimeout(function(){
                                window.location = "{{ route('dashboard.groups.index') }}";
                            }, 1500);
                        }
                    });
                }
            })
        }

    </script>
@endsection




