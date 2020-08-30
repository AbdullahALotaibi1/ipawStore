@extends('dashboard.layouts.app')

@section('title','المشتركين')

@section('content')
    <div class="container-fluid">
        <div class="header-body ">
            <div class="row align-items-start">
                <div class="col-auto">

                    <!-- Button -->
                    <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary lift">
                        اضافة مشترك
                    </a>
                </div>
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
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-nowrap card-table table-live-data">
                    <thead>
                    <tr>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="orders-order">
                                رقم المشترك
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="orders-product">
                                اسم المشترك
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="orders-date">
                                UDID
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="orders-date">
                                جوال المشترك
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="orders-total">
                                مجموعة المشترك
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="orders-status">
                                جهاز المشترك
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort" data-sort="orders-method">
                                حالة المشترك
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

                        <td class="orders-order">
                            #65
                        </td>
                        <td class="orders-product">
                           عبدالله العتيبي
                        </td>
                        <td class="orders-date">
                            <span class="badge badge-soft-secondary">
                              002ebf12-a125-5ddf-a739-67c3c5d20177
                            </span>
                        </td>
                        <td class="orders-total">
                            0564893457
                        </td>
                        <td class="orders-status">
                            <span class="small text-gray-700" >
                                  مجموعة 36
                            </span>
                        </td>
                        <td class="orders-method">
                            <!-- Badge -->
                            iPhone X
                        </td>
                        <td class="orders-method">
                            <!-- Badge -->
                            <div class="badge badge-soft-success">
                                مفعل
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
                        <td class="orders-order">
                            #65
                        </td>
                        <td class="orders-product">
                            عبدالله العتيبي
                        </td>
                        <td class="orders-date">
                            <span class="badge badge-soft-secondary">
                              002ebf12-a125-5ddf-a739-67c3c5d20177
                            </span>
                        </td>
                        <td class="orders-total">
                            0564893457
                        </td>
                        <td class="orders-status">
                            <span class="small text-gray-700" >
                                  مجموعة 36
                            </span>
                        </td>
                        <td class="orders-method">
                            <!-- Badge -->
                            iPhone X
                        </td>
                        <td class="orders-method">
                            <!-- Badge -->
                            <div class="badge badge-soft-success">
                                مفعل
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
