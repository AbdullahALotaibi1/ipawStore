@extends('dashboard.layouts.app')

@section('title','الرئيسية')

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
                    <h1 class="header-title">
                        الرئيسية
                    </h1>

                </div>
            </div> <!-- / .row -->
        </div><br>
        <div class="row">
            <div class="col-12 col-lg-6 col-xl">
                <!-- Value  -->
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <!-- Title -->
                                <h6 class="text-uppercase text-muted mb-2">
                                    عدد التطبيقات
                                </h6>
                                <!-- Heading -->
                                <span class="h2 mb-0">
                                     {{ $countApplications }}
                                </span>
                            </div>
                            <div class="col-auto">
                                <!-- Icon -->
                                <span class="h2 fe fe-dollar-sign text-muted mb-0"></span>
                            </div>
                        </div> <!-- / .row -->
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl">
                <!-- Value  -->
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <!-- Title -->
                                <h6 class="text-uppercase text-muted mb-2">
                                    عدد الطلبات
                                </h6>
                                <!-- Heading -->
                                <span class="h2 mb-0">
                                     {{ $countOrders }}
                                </span>
                            </div>
                            <div class="col-auto">
                                <!-- Icon -->
                                <span class="h2 fe fe-dollar-sign text-muted mb-0"></span>
                            </div>
                        </div> <!-- / .row -->
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl">
                <!-- Value  -->
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <!-- Title -->
                                <h6 class="text-uppercase text-muted mb-2">
                                    عدد المشتركين
                                </h6>
                                <!-- Heading -->
                                <span class="h2 mb-0">
                                     {{ $countCustomers }}
                                </span>
                            </div>
                            <div class="col-auto">
                                <!-- Icon -->
                                <span class="h2 fa fa-user-friends text-muted mb-0"></span>
                            </div>
                        </div> <!-- / .row -->
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl">
                <!-- Value  -->
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
                                     {{ $countGroups }}
                                </span>
                            </div>
                            <div class="col-auto">
                                <!-- Icon -->
                                <span class="h2 fa fa-window-restore text-muted mb-0"></span>
                            </div>
                        </div> <!-- / .row -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="card" data-list='{"valueNames": ["order_id", "full_name", "phone_number", "udid"]}'>
            <div class="card-header">
               اخر 10 طلبات جديدة
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
                            <a href="#" class="text-muted list-sort">
                                حالة الطلب
                            </a>
                        </th>
                        <th>
                            <a href="#" class="text-muted list-sort">
                                تاريخ الطلب
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="list">
                    @foreach($lastOrders as $order)
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
                                <!-- Badge -->
                                <div class="badge badge-soft-{{ $order->getStatus()['className'] }}">
                                    {{ $order->getStatus()['status'] }}
                                </div>
                            </td>
                            <td class="">
                                {{ $order->getLastUpdate() }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
