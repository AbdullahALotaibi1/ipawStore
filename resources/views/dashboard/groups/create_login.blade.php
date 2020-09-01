@extends('dashboard.layouts.app')

@section('title','اضافة مجموعة')

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
                        المجموعات
                    </h6>

                    <!-- Title -->
                    <h1 class="header-title">
                         الاجهزة المسجلة في الشهادة
                    </h1>

                </div>
            </div> <!-- / .row -->
        </div>

        <! ============ Form
        =======================>

        <br>
        <div class="col-lg-12 col-md-12" style="direction: rtl">
            <div class="row">
                <div class="col-lg-9 col-md-12">
                    <!-- Form -->
                    <form class="mb-4">

                        <!-- Project name -->
                        <div class="form-group">

                            <!-- Label  -->
                            <label>
                                الأجهزة المسجلة
                            </label>
                            <!-- Text -->
                            <small class="form-text text-muted">
                               تم ايجاد عدد من الاجهزة المسجلة في الشهادة
                            </small>

                            <!-- Input -->
                            <div class="card">
                                <div class="card-body">

                                    <!-- List group -->
                                    <div class="list-group list-group-flush my-n3">
                                        @foreach($devices as $key => $device)
                                            @if($key <= 2)
                                            <div class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <!-- Icon -->
                                                        <i class="fe fe-smartphone h1"></i>
                                                    </div>
                                                    <div class="col ml-n2">
                                                        <!-- Heading -->
                                                        <h4 class="mb-1">
                                                            {{ $device['model'] }}
                                                        </h4>
                                                        <!-- Text -->
                                                        <small class="text-muted">
                                                            <time >{{ $device['udid'] }}</time>
                                                        </small>
                                                    </div>
                                                    <div class="col-auto">
                                                        <!-- Button -->
                                                        <button type="button" class="btn btn-sm btn-white">
                                                            مفعل
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                            @if(count($devices) >= 4)
                                                <div class="list-group-item">
                                                    <div class="text-center mt-2">

                                                       يوجد اكثر من {{ count($devices) - 3 }}+ جهاز
                                                    </div>
                                                </div>
                                            @endif
                                    </div>

                                </div>
                            </div>
                        </div>

                        <form action="{{ route('dashboard.groups.store') }}" method="post">
                            @csrf
                            @method('post')
                            <input name="group_id" value="{{ $group_id }}" hidden>

                            <!-- Buttons -->
                            <button type="submit" class="btn btn-block btn-primary">
                                اضافة كل الاجهزة
                            </button>
                        </form>


                    </form>
                </div>
                <div class="col-lg-3 col-md-12">
                    <div class="row">

                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
