@extends('welcome')
@section('content')

    <header class="bg-dark pt-9 pb-11 d-md-block" style="text-align: right">
        <div class="container-md">
            <div class="row align-items-center">
                <div class="col">
                    <!-- Heading -->
                    <h1 class="font-weight-bold text-white mb-2">
                         تحديث بيانات حسابك
                    </h1>
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </header>


    <main class="pb-8 pb-md-11 mt-md-n6  pb-sm-11 mt-sm-n6" style="direction: rtl; text-align: right">
        <form action="{{ route('update.request') }}" method="post">
            @csrf
            @method('post')
            <input class="form-control" value="{{ $udid }}" name="udid" hidden>
            <div class="container-md">
                <div class="row">
                    <div class="col-12 col-md-12 orderDiv" >
                        <!-- Card -->
                        <div class="card card-bleed shadow-light-lg mb-6">
                            <div class="card-header">
                                <!-- Heading -->
                                <h4 class="mb-0">
                                    نموذج تحديث الحساب
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
                                                <input class="form-control @error('udid') is-invalid @enderror" disabled value="{{ $udid }}" id="text" name="udid"  type="udid">
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

                    <div class="col-12 col-md-auto" style="margin-top: 20px">

                        <!-- Button -->
                        <button class="btn btn-block btn-primary orderDiv"  type="submit">
                            حفظ البيانات
                        </button>
                    </div>

                </div> <!-- / .row -->
            </div> <!-- / .container -->
        </form>
    </main>
@endsection


