@extends('dashboard.layouts.app')

@section('title','الصندوق الذكي')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css" >
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
                            <a  class="nav-link text-center " id="appStore-tab" data-toggle="tab" href="#appStore" role="tab" aria-controls="appStore" aria-selected="false">
                               اضافة App Store
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

        @if(Session::has('message'))
            <div class="col-12">

                <!-- Warning -->
                <div class="card bg-success border" style="direction: rtl;">
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



            <! ============ appStore
            ==========================>
            <div class="tab-pane fade show " id="appStore" role="tabpanel" aria-labelledby="appStore-tab">

                <div class="card" >
                    <div class="card-header">

                        <!-- Title -->
                        <h4 class="card-header-title">
                            تطبيقات App Store
                        </h4>

                    </div>
                    <div class="card-header" >

                        <!-- Form -->
                        <form>
                            <div class="input-group input-group-flush input-group-merge">
                                <input type="search" class="form-control form-control-prepended list-search" placeholder="Search" id="searchAppStore">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span class="fe fe-search"></span>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="card-body" id="tableOfApp">
                        <!-- List -->
                        <ul class="list-group list-group-lg list-group-flush list my-n4" id="appData">
                        </ul>
                    </div>


                </div>
                <div class="pagination-app" style="direction: rtl" id="getAppPage">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item"><button type="button" class="page-link" onclick="PreviousAppPage()">السابق</button></li>
                            <li class="page-item"><button type="button" class="page-link" onclick="NextAppPage()">التالي</button></li>
                        </ul>
                    </nav>
                </div>

                <div class="pagination-app" style="direction: rtl" id="searchPage">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item"><button type="button" class="page-link" onclick="PreviousSearchPage()">السابق</button></li>
                            <li class="page-item"><button type="button" class="page-link" onclick="NextSearchPage()">التالي</button></li>
                        </ul>
                    </nav>
                </div>


            </div>


            <! ============ myApp
            ==========================>
            <div class="tab-pane fade show " id="myApp" role="tabpanel" aria-labelledby="myApp-tab">

                <div class="card">
                    <div class="card-header">
                        <!-- Search -->
                       التطبيقات المرفوعة
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-nowrap card-table table-live-data" id="">
                            <thead>
                            <tr>
                                <th>
                                    <a href="#" class="text-muted list-sort" >
                                        ترتيب التطبيق
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-muted list-sort" data-sort="app-id">
                                        رقم التطبيق
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-muted list-sort">
                                         ايقونة التطبيق
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-muted list-sort" data-sort="app-name">
                                       اسم التطبيق
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-muted list-sort" data-sort="bundle-id">
                                       بندل التطبيق
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-muted list-sort" >
                                      اصدار التطبيق
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-muted list-sort" >
                                        حجم التطبيق
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
                            <tbody class="list sortable-pro">
                            @foreach($applications as $app)
                                <tr class="row1" data-id="{{ $app['id'] }}">
                                    <td class="orders-product handle cursor-move">
                                        {{ $app['app_arrangement'] }}
                                    </td>
                                    <td class="orders-product">
                                        {{ $app['id'] }}
                                    </td>
                                    <td class="orders-date">
                                        <img src="{{ asset("storage/store/_icon/".$app['app_icon']."") }}" class="app_icon">
                                    </td>
                                    <td class="orders-total">
                                        {{ $app['app_name'] }}
                                    </td>
                                    <td class="orders-status">
                                        {{ $app['app_bundle'] }}
                                    </td>
                                    <td class="orders-method">
                                        {{ $app['app_version'] }}
                                    </td>
                                    <td class="orders-status">
                                        {{ $app['app_size'] }}
                                    </td>
                                    <td class="orders-status">
                                        {{ $app->getLastUpdate() }}
                                    </td>
                                    <td class="text-right">
                                        <!-- Dropdown -->
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fe fe-more-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" onclick="deleteApp({{ $app['id'] }})">
                                                    حذف
                                                </a>
                                                <a href="{{ route('dashboard.applications.edit', $app['id']) }}" class="dropdown-item">
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

            </div>

        </div>


    </div>

@endsection


@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>

        var page_id = 1;
        var ask = false

        // Setup Ajax
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });



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


        $(document).ready(function() {

            // DataTable Methods
            $(".sortable-pro").sortable({
                handle: '.handle',
                update: function () {
                    sendOrderToServer()
                }
            }).disableSelection();

            function sendOrderToServer() {
                let order = [];
                $('tr.row1').each(function(index) {
                    // Update Child td
                    var child = this.childNodes[1].innerHTML = index + 1
                    // update
                    console.log($(this).attr('data-id'));
                    order.push({
                        id: $(this).attr('data-id'),
                        position: index + 1
                    });

                });
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('dashboard.applications.ajax.sortable') }}",
                    data: {
                        order: order,
                    },
                    success: function(response) {

                    }
                });

                Toast.fire({
                    icon: 'success' ,
                    title: 'تم تحديث ترتيب التطبيقات'
                })
            }
        });


        // Delete App Function
        function deleteApp(app_id)
        {
            Swal.fire({
                title: 'هل انت متاكد؟',
                text: "هل انت متاكد من حذف التطبيق، سيتم حذف كل التطبيقات الموقعة في المجموعات الموجودة",
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
                        url: "{{ route('dashboard.applications.ajax.delete') }}",
                        data: {app_id:  app_id},
                        success: function( msg ) {
    console.log(msg)
                            Swal.fire(
                                'بنجاح!',
                                'تم حذف التطبيق بنجاح.',
                                'success'
                            )

                        }
                    });
                }
            })
        }

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
            timeout: 90000000000000000000000000000000000000, /*milliseconds*/
            maxFilesize: 50000000000000000000000,
            maxFiles: 20,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
        Dropzone.prototype.defaultOptions.dictDefaultMessage = "lorem ipsum";

        // get app data
        $(document).ready(function(){
            $('#searchPage').hide();
          getListApp(page_id);
        });

        function getListApp(page_id){
            $('.list-group-item').remove();
            $('#appData').append(`
                             <li class="list-group-item">
                                <div class="row align-items-center" style="direction: rtl;">
                                    <div class="col-auto text-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div> <!-- / .row -->
                            </li>
                            `);
            $.ajax({
                type:'post',
                url: "{{ route('dashboard.applications.ajax.getListApp') }}",
                data: {page_id:  page_id},
                success: function( data ) {

                    $('.list-group-item').remove();

                    $.each(data['data']['list'], function(index, el) {
                        $('#appData').append(`
                            <li class="list-group-item" data-id="${el['id']}">
                                <div class="row align-items-center" style="direction: rtl;">
                                    <div class="col-auto">

                                        <!-- Avatar -->
                                        <a href="#!" class="avatar avatar-lg">
                                            <img src="${el['icon']}" alt="..." class="avatar-img rounded">
                                        </a>

                                    </div>
                                    <div class="col ml-n2">

                                        <!-- Title -->
                                        <h4 class="mb-1 name">
                                            <a href="#!">${el['name']}</a>
                                        </h4>

                                        <!-- Text -->
                                        <p class="card-text small text-muted mb-1">
                                            الاصدار <strong>${el['ver']}</strong>
                                        </p>

                                        <!-- Time -->
                                        <p class="card-text small text-muted">
                                            ${el['bundleid']}
                                        </p>

                                    </div>
                                    <div class="col-auto">

                                        <!-- Button -->
                                        <button type="button" data-id="${el['id']}" data-name="${el['name']}" id="button-${el['id']}" class="btn resginApp btn-sm btn-white d-none d-md-inline-block">
                                            توقيع
                                        </button>
                                         <div class="spinner-border text-primary" id="loading-${el['id']}" style="display: none;" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>

                                    </div>
                                </div> <!-- / .row -->
                            </li>
                        `);
                        // Do your stuff

                    });

                }
            });
        }


            function NextAppPage(){
                page_id += 1
                getListApp(page_id);
            }

            function PreviousAppPage(){
                if(page_id >= 2){
                    page_id  -= 1
                    getListApp(page_id);
                }
            }

            function NextSearchPage(){
                page_id += 1
                getListApp(page_id);
            }

            function PreviousSearchPage(){
                if(page_id >= 2){
                    page_id  -= 1
                    getListApp(page_id);
                }
            }


            function getSearchApp(page_id, qsearch){
                $('.list-group-item').remove();
                $('#appData').append(`
                             <li class="list-group-item">
                                <div class="row align-items-center" style="direction: rtl;">
                                    <div class="col-auto text-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div> <!-- / .row -->
                            </li>
                            `);
                $.ajax({
                    type:'post',
                    url: "{{ route('dashboard.applications.ajax.appSearch') }}",
                    data: {page_id: page_id, qsearch: qsearch},
                    success: function( data ) {
                        $('.list-group-item').remove();
                        $.each(data['data']['list'], function(index, el) {
                            $('#appData').append(`
                            <li class="list-group-item" data-id="${el['id']}">
                                <div class="row align-items-center" style="direction: rtl;">
                                    <div class="col-auto">

                                        <!-- Avatar -->
                                        <a href="#!" class="avatar avatar-lg">
                                            <img src="${el['icon']}" alt="..." class="avatar-img rounded">
                                        </a>

                                    </div>
                                    <div class="col ml-n2">

                                        <!-- Title -->
                                        <h4 class="mb-1 name">
                                            <a href="#!">${el['name']}</a>
                                        </h4>

                                        <!-- Text -->
                                        <p class="card-text small text-muted mb-1">
                                            الاصدار <strong>${el['ver']}</strong>
                                        </p>

                                        <!-- Time -->
                                        <p class="card-text small text-muted">
                                            ${el['bundleid']}
                                        </p>

                                    </div>
                                    <div class="col-auto">

                                        <!-- Button -->
                                        <button type="button" data-id="${el['id']}" data-name="${el['name']}" id="button-${el['id']}" class="btn resginApp btn-sm btn-white d-none d-md-inline-block">
                                            توقيع
                                        </button>
                                         <div class="spinner-border text-primary" id="loading-${el['id']}" style="display: none;" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>

                                    </div>
                                </div> <!-- / .row -->
                            </li>
                        `);
                            // Do your stuff
                        });

                    }
                });
            }



            $("#searchAppStore").keyup(function(e) {
                var q = $("#searchAppStore").val();
                page_id = 1;
                if(q == ''){
                    $('getAppPage').show();
                    $('#searchPage').hide();
                    getListApp(page_id)
                }
                $('#getAppPage').hide();
                $('#searchPage').show();
                getSearchApp(page_id, q);
            });

        $(document).on('click', '.resginApp', function(){
            ask = true;
            var appID = $(this).attr('data-id');
            var appName = $(this).attr('data-name');
            document.getElementById("button-"+ appID).style.setProperty("display", "none", "important")
            document.getElementById("loading-"+ appID).style.display = "block";

            // Send toast
            Toast.fire({
                icon: 'success',
                title: 'جاري تنزيل التطبيق ('+ appName +') وتوقيعة على كل المجموعات'
            })

            // ajax

            $.ajax({
                type:'post',
                url: "{{ route('dashboard.applications.ajax.resignApp') }}",
                data: {app_id:  appID},
                success: function(response) {
                    if(response['success'] == true){
                        Toast.fire({
                            icon: 'success',
                            title: response['message']
                        })
                    }else{
                        Toast.fire({
                            icon: 'error',
                            title: response['message']
                        })
                    }
                    document.getElementById("button-"+ appID).style.setProperty("display", "block", "important")
                    document.getElementById("loading-"+ appID).style.display = "none";
                    ask = false;
                }
            });

        });

            window.onbeforeunload = function(e) {
                if(!ask) return null
                return 'Sure?';
            }

    </script>
@endsection
