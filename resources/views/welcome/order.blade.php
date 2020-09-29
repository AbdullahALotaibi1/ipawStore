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
        <form action="{{ route('order.request') }}" method="post">
            @csrf
            @method('post')
            <input class="form-control" value="{{ old('device_model', $deviceName) }}" name="device_model" hidden>
            <input class="form-control" value="{{ $udid }}" name="udid" hidden>

            <div class="container-md">
            <div class="row">
                <div class="col-12 col-md-12 orderDiv" >
                    <!-- Card -->
                    <div class="card card-bleed shadow-light-lg mb-6">
                        <div class="card-header">
                            <!-- Heading -->
                            <h4 class="mb-0">
                                نموذج طلب الاشتراك
                            </h4>
                        </div>
                        <div class="card-body">
                            <!-- Form -->
                            <form>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <!-- Name -->
                                        <div class="form-group">
                                            <label for="name">الاسم كامل</label>
                                            <small>الرجاء كتابة اسمك الذي قمت بتحويل المبلغ فيه.</small>
                                            <input class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name') }}" id="name" name="full_name" type="text" placeholder="مثال: عبدالله مطلق العتيبي">
                                            @error('full_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-12 col-md-6">
                                        <!-- Email -->
                                        <div class="form-group">
                                            <label for="phone">رقم الجوال</label>
                                            <small>الرجاء كتابة رقم الجوال بصغية : (96655xxxxxx)</small>
                                            <input class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number') }}" id="phone" name="phone_number"  type="phone" placeholder="مثال: 96655xxxxxx">
                                            @error('phone_number')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <!-- Email -->
                                        <div class="form-group">
                                            <label for="udid">رقم UDID</label>
                                            <input class="form-control @error('udid') is-invalid @enderror" disabled value="{{ $udid }}" id="text" name="udid"  type="text">
                                            @error('udid')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <!-- Email -->
                                        <div class="form-group">
                                            <label for="udid">كود الاشتراك</label>
                                            <input class="form-control @if (session('register_coupon')) is-invalid @endif"  value="{{ old('register_coupon') }}" id="text" name="register_coupon" placeholder="كود الاشتراك" type="text">
                                            @if (session('register_coupon'))
                                                <div class="invalid-feedback">
                                                    {{ session('register_coupon') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <!-- Email -->
                                        <div class="form-group">
                                            {!! captcha_img('math') !!}
                                            <input class="form-control @error('captcha') is-invalid @enderror" style="margin-top: 10px;" type="text" name="captcha" placeholder="كود التحقق">
                                            @error('captcha')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>


                {{-- Dvieces --}}
                <div class="col-12 col-md-12 orderDiv" style="">
                    <div class="card card-bleed shadow-light-lg">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">

                                <!-- Heading -->
                                <h4 class="mb-0">
                                    الجهاز المسجل
                                </h4>

                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <!-- List group -->
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col-auto">

                                        <!-- Icon -->
                                        <div class="icon icon-sm text-gray-400">
                                            <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><path d="M0 0h24v24H0z"></path><path d="M8 2.5c-.69 0-1.25.56-1.25 1.25v16.5c0 .69.56 1.25 1.25 1.25h8c.69 0 1.25-.56 1.25-1.25V3.75c0-.69-.56-1.25-1.25-1.25H8z" fill="#335EEA" opacity=".3"></path><path d="M8 2.5c-.69 0-1.25.56-1.25 1.25v16.5c0 .69.56 1.25 1.25 1.25h8c.69 0 1.25-.56 1.25-1.25V3.75c0-.69-.56-1.25-1.25-1.25H8zM8 1h8a2.75 2.75 0 012.75 2.75v16.5A2.75 2.75 0 0116 23H8a2.75 2.75 0 01-2.75-2.75V3.75A2.75 2.75 0 018 1zm1.5.75h5a.5.5 0 01.5.5v1a.5.5 0 01-.5.5h-5a.5.5 0 01-.5-.5v-1a.5.5 0 01.5-.5z" fill="#335EEA"></path></g></svg>
                                        </div>

                                    </div>
                                    <div class="col ml-n5">

                                        <!-- Heading -->
                                        <p class="mb-0">
                                            {{ $deviceName }}
                                        </p>

                                        <!-- Text -->
                                        <small class="text-gray-700">
                                            {{ $udid }}
                                        </small>

                                    </div>
                                </div>
                            </div>



                        </div>

                    </div>
                </div>
                </div>
                <div class="col-12 col-md-auto" style="margin-top: 20px">

                    <!-- Button -->
                    <button class="btn btn-block btn-primary orderDiv"  type="submit">
                        اشتراك
                    </button>
                </div>
                <div class="col-12 col-md-12 orderDiv" style="display: none; margin-top: 20px">
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


            </div> <!-- / .row -->
        </div> <!-- / .container -->
        </form>
    </main>
@endsection


