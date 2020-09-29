@extends('welcome')
@section('content')

<header class="bg-dark pt-9 pb-11 d-md-block" style="text-align: right">
    <div class="container-md">
        <div class="row align-items-center">
            <div class="col">
            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</header>


<main class="pb-8 pb-md-11 mt-md-n6  pb-sm-11 mt-sm-n6" style="direction: rtl; text-align: right; margin-top: -100px !important;">
    <div class="container-md">
        <div class="row">
            @if($codeStatus == true)
                <div class="col-12 col-md-12" style="margin-bottom: 15px;">
                    <!-- Button -->
                    <button class="btn btn-block btn-primary activeCustomer"  type="submit">
                        تفعيل حساب
                    </button>
                </div>
            @endif
            <div class="col-12 col-md-12">

                <!-- Card -->
                <div class="card card-bleed shadow-light-lg">
                    <div class="card-header">

                        <!-- Heading -->
                        <h4 class="mb-0">
                            @if($codeStatus == true)
                                بيانات المشترك
                            @else
                                بيانات الطلب
                            @endif
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- List group -->
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <!-- Heading -->
                                        <p class="mb-0">
                                            <a href="#">  @if($codeStatus == true)
                                                              رقم المشترك
                                                @else
                                                    رقم الطلب
                                                @endif
                                                    #{{ $orderID }}</a>
                                        </p>
                                        <!-- Text -->
                                        <small class="text-gray-700">
                                            {{ $fullName }}
                                        </small>
                                        <small class="text-gray-700">
                                            <p>{{ $phoneNumber }}</p>
                                        </small>
                                    </div>
                                    <div class="col-auto">
                                        <!-- Button -->
                                        <span class="badge badge-pill badge-success-soft">

                                            @if($codeStatus == true)
                                                <span class="h6 text-uppercase font-weight-bold">تم الاشتراك</span>
                                            @else
                                                <span class="h6 text-uppercase font-weight-bold">تم تقديم الطلب</span>
                                            @endif

                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Dvieces --}}
            <div class="col-12 col-md-12 orderDiv" style="margin-top: 30px;">
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
                                            {{ $deviceModel }}
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
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</main>

@if($codeStatus == true)
<!-- Modal -->
<div class="modal fade" id="downloadAppStore" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="direction: rtl;
    text-align: right;">
                <h5 class="modal-title" id="staticBackdropLabel">تحميل تطبيق المتجر</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="    padding: 15px;
    direction: rtl;
    text-align: right;">

                <div class="form-group">
                    <!-- Label  -->
                    <label>
                        تحميل تطبيق المتجر
                    </label>
                    <!-- Text -->
                    <small class="form-text text-muted">
                       تم توقيع التطبيق بنجاح قم بتضغط على تحميل المتجر.
                    </small>

                    <!-- Input -->
                    <a href="{{ route('download.appstore', $udid) }}" class="btn btn-primary" id="createNewActiveCode" style="width: 100%; margin-top: 15px;">تحميل</a>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/welcome/js/waitingfor.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        })

        $(document).on('click', '.activeCustomer', function (){
            waitingDialog.show('جاري تفعيل حسابك.');
            // Setup Ajax

            $.ajax({
                type:'post',
                url: "{{ route('active.customer') }}",
                data: {order_id: '{{ $orderID }}', udid: '{{ $udid }}',},
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
                        $('#downloadAppStore').modal('show');
                    }
                    waitingDialog.hide();
                }
            });
        });
    </script>
    @endif
@endsection
