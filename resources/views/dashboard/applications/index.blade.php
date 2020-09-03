@extends('dashboard.layouts.app')

@section('title','الصندوق الذكي')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css">
@endsection

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
                        الصندوق الذكي
                    </h1>

                </div>
            </div> <!-- / .row -->
            <div class="row">
                <div class="col-12">

                    <ul class="nav nav-tabs header-tabs" id="myTabMulit" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-center active" id="uploadApp-tab" data-toggle="tab" href="#uploadApp" role="tab" aria-controls="information" aria-selected="true">
                                رفع التطبيقات
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center" id="arabCrack-tab" data-toggle="tab" href="#arabCrack" role="tab" aria-controls="compensation" aria-selected="false">
                                اضافة عرب كراك
                            </a>
                        </li>
                        <li class="nav-item">
                            <a  class="nav-link text-center " id="iPhoneCake-tab" data-toggle="tab" href="#iPhoneCake" role="tab" aria-controls="appleAccount" aria-selected="false">
                               اضافة iPhoneCake
                            </a>
                        </li>

                        <li class="nav-item">
                            <a  class="nav-link text-center " id="myApp-tab" data-toggle="tab" href="#myApp" role="tab" aria-controls="appleAccount" aria-selected="false">
                                التطبيقات المرفوعة
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
        <br>


        <div class="tab-content" id="myTabContent">


            <! ============ uploadApp
            ==========================>
            <div class="tab-pane fade show active" id="uploadApp" role="tabpanel" aria-labelledby="uploadApp-tab">

                <div class="card">
                    <div class="card-header">

                        <!-- Title -->
                        <h4 class="card-header-title">
                            رفع وتوقيع التطبيقات
                        </h4>

                    </div>
                    <div class="card-body">

                        <form action="/file-upload" class="dropzone" id="uploadApplication">

                        </form>

                    </div>
                </div>



            </div>






            <! ============ arabCrack
            ==========================>

            <div class="tab-pane fade show " id="arabCrack" role="tabpanel" aria-labelledby="arabCrack-tab">
                arabCrack
            </div>



            <! ============ iPhoneCake
            ==========================>
            <div class="tab-pane fade show " id="iPhoneCake" role="tabpanel" aria-labelledby="iPhoneCake-tab">
                iPhoneCake
            </div>


            <! ============ myApp
            ==========================>
            <div class="tab-pane fade show " id="myApp" role="tabpanel" aria-labelledby="myApp-tab">
                myApp
            </div>

        </div>


    </div>

@endsection


@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script>

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-start',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })




        var dropzone = new Dropzone('#uploadApplication', {
            url: "{{ route('dashboard.applications.ajax.uploadApp') }}",
            previewsContainer: ".dropzone",
            clickable: ".dropzone",
            dictDefaultMessage : "قم برفع التطبيقات بصيغة ipa",
            init: function () {
                this.on("success", function (file, response) {
                    Toast.fire({
                        icon: response['success'] == true ? 'success' : 'warning',
                        title: response['message']
                    })
                    console.log(response);
                });
            },
            acceptedFiles: ".ipa",
            uploadMultiple: true,
            parallelUploads: 1,
            maxFilesize: 50000000000000000000000,
            maxFiles: 20,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });

        Dropzone.prototype.defaultOptions.dictDefaultMessage = "lorem ipsum";





    </script>
@endsection
