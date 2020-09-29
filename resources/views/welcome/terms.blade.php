@extends('welcome')
@section('content')

    <header class="bg-dark pt-9 pb-11 d-md-block" style="text-align: right">
        <div class="container-md">
            <div class="row align-items-center">
                <div class="col">
                    <!-- Heading -->
                    <h1 class="font-weight-bold text-white mb-2">
                        طلب اشتراك
                    </h1>
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </header>


    <main class="pb-8 pb-md-11 mt-md-n6  pb-sm-11 mt-sm-n6" style="direction: rtl; text-align: right">
        <div class="container-md">
            <div class="row">
                <div class="col-12 col-md-12 agreeTermsDiv">
                    <!-- Card -->
                    <div class="card card-bleed shadow-light-lg mb-6">
                        <div class="card-header">
                            <!-- Heading -->
                            <h4 class="mb-0">
                                شروط المتجر
                            </h4>
                        </div>
                        <div class="card-body">
                            {!! \App\Setting::all()->first()->conditions_order !!}
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-12 agreeTermsDiv">
                    <div class="card card-bleed shadow-light-lg mb-6">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">

                                    <!-- Heading -->
                                    <h4 class="mb-0">
                                        بيانات الدفع
                                    </h4>

                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <!-- List group -->
                            <div class="list-group list-group-flush">
                                @foreach($banks as $bank)
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <!-- Icon -->
                                                <img class="img-fluid" src="{{ asset(\Illuminate\Support\Facades\URL::to('/').'/storage/images/banks/'.$bank->bank_image.'') }}" alt="..." style="max-width: 40px; border-radius: 8px">
                                            </div>
                                            <div class="col ml-n5">

                                                <!-- Heading -->
                                                <p class="mb-0">
                                                    {{ $bank->owner_name }}
                                                </p>

                                                <!-- Text -->
                                                <small class="text-gray-700">
                                                    الآيبان: {{ $bank->iban }}
                                                </small>

                                                <!-- Text -->
                                                <small class="text-gray-700">
                                                    <p class="mb-0">
                                                        رقم الحساب: {{ $bank->account_number }}
                                                    </p>
                                                </small>

                                            </div>
                                            <div class="col-auto mr-n5">
                                                <!-- Badge -->
                                                <span class="badge badge-pill badge-success-soft">
                                              <span class="h6 text-uppercase font-weight-bold">متاح</span>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-auto">

                    <!-- Button -->
                    <a class="btn btn-block btn-primary" href="{{ route('order.get.udid', [$udid, $deviceName]) }}">
                        الموافقة على الشروط
                    </a>
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </main>

@endsection
