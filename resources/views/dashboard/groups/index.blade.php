@extends('dashboard.layouts.app')

@section('title','المجموعات')

@section('content')
    <div class="container-fluid">
        <div class="header-body ">
        <div class="row align-items-start">
            <div class="col-auto">

                <!-- Button -->
                <a href="{{ route('dashboard.groups.create') }}" class="btn btn-primary lift">
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

        <! ============ Table
         =======================>

        <br>
        <!-- Card -->
        <div class="card" data-list='{"valueNames": ["orders-order", "orders-product", "orders-date", "orders-total", "orders-status", "orders-method"]}'>
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

                <!-- Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-sm btn-white dropdown-toggle" type="button" id="bulkActionDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        الاجراءات
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bulkActionDropdown">
                        <a class="dropdown-item" href="#!">Action</a>
                        <a class="dropdown-item" href="#!">Another action</a>
                        <a class="dropdown-item" href="#!">Something else here</a>
                    </div>
                </div>

            </div>
            <div class="table-responsive">
                <table class="table table-sm table-nowrap card-table table-live-data">
                    <thead>
                    <tr>
                        <th>

                            <!-- Checkbox -->
                            <div class="custom-control custom-checkbox table-checkbox">
                                <input type="checkbox" class="list-checkbox-all custom-control-input" name="ordersSelect" id="ordersSelectAll">
                                <label class="custom-control-label" for="ordersSelectAll">&nbsp;</label>
                            </div>

                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="orders-order">
                                رقم المجموعة
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="orders-product">
                                اسم المجموعة
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="orders-date">
                                اسم الشهادة
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="orders-total">
                                عدد المشتركين
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="orders-status">
                                صلاحية الشهادة
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="orders-method">
                                حالة المجموعة
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
                    <tr>
                        <td>
                            <!-- Checkbox -->
                            <div class="custom-control custom-checkbox table-checkbox">
                                <input type="checkbox" class="list-checkbox custom-control-input" name="ordersSelect" id="ordersSelectOne">
                                <label class="custom-control-label" for="ordersSelectOne">&nbsp;</label>
                            </div>
                        </td>
                        <td class="orders-order">
                            #6521
                        </td>
                        <td class="orders-product">
                            مجموعة 36
                        </td>
                        <td class="orders-date">
                            X9DLA0D283
                        </td>
                        <td class="orders-total">
                            98 مشترك
                        </td>
                        <td class="orders-status">
                            متبقي 192 يوم
                        </td>
                        <td class="orders-method">
                            <!-- Badge -->
                            <div class="badge badge-soft-success">
                                متاحة
                            </div>
                        </td>
                        <td class="text-right">

                            <!-- Dropdown -->
                            <div class="dropdown">
                                <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fe fe-more-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="#!" class="dropdown-item">
                                        Action
                                    </a>
                                    <a href="#!" class="dropdown-item">
                                        Another action
                                    </a>
                                    <a href="#!" class="dropdown-item">
                                        Something else here
                                    </a>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr>
                        <td>
                            <!-- Checkbox -->
                            <div class="custom-control custom-checkbox table-checkbox">
                                <input type="checkbox" class="list-checkbox custom-control-input" name="ordersSelect" id="ordersSelectOne">
                                <label class="custom-control-label" for="ordersSelectOne">&nbsp;</label>
                            </div>
                        </td>
                        <td class="orders-order">
                            #6522
                        </td>
                        <td class="orders-product">
                            مجموعة 37
                        </td>
                        <td class="orders-date">
                            S02LA5AS84
                        </td>
                        <td class="orders-total">
                            100 مشترك
                        </td>
                        <td class="orders-status">
                            متبقي 291 يوم
                        </td>
                        <td class="orders-method">
                            <!-- Badge -->
                            <div class="badge badge-soft-warning">
                                الحد الاعلى
                            </div>
                        </td>
                        <td class="text-right">

                            <!-- Dropdown -->
                            <div class="dropdown">
                                <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fe fe-more-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="#!" class="dropdown-item">
                                        Action
                                    </a>
                                    <a href="#!" class="dropdown-item">
                                        Another action
                                    </a>
                                    <a href="#!" class="dropdown-item">
                                        Something else here
                                    </a>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr>
                        <td>
                            <!-- Checkbox -->
                            <div class="custom-control custom-checkbox table-checkbox">
                                <input type="checkbox" class="list-checkbox custom-control-input" name="ordersSelect" id="ordersSelectOne">
                                <label class="custom-control-label" for="ordersSelectOne">&nbsp;</label>
                            </div>
                        </td>
                        <td class="orders-order">
                            #6523
                        </td>
                        <td class="orders-product">
                            مجموعة 38
                        </td>
                        <td class="orders-date">
                            P24LG6ATE9
                        </td>
                        <td class="orders-total">
                            100 مشترك
                        </td>
                        <td class="orders-status">
                            متبقي 30 يوم
                        </td>
                        <td class="orders-method">
                            <!-- Badge -->
                            <div class="badge badge-soft-danger">
                                مغلقة
                            </div>
                        </td>
                        <td class="text-right">

                            <!-- Dropdown -->
                            <div class="dropdown">
                                <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fe fe-more-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="#!" class="dropdown-item">
                                        Action
                                    </a>
                                    <a href="#!" class="dropdown-item">
                                        Another action
                                    </a>
                                    <a href="#!" class="dropdown-item">
                                        Something else here
                                    </a>
                                </div>
                            </div>

                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
