<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <link rel="shortcut icon" href="{{asset('assets/img/logo.png') }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') || Sistem Wakaf</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
    {{-- SweetAlert2 --}}
    <script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <link href="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    @yield('css')
    <link rel="stylesheet" href="{{asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}">
<style>
    .file-upload {
        background-color: #ffffff;
        width: 18em;
        position: relative;
    }

    .box-remove {
        position: absolute;
        display: none;
        bottom: 0;
        right: 0;
        margin: 10px;
        z-index: 1;
    }

    .file-upload-content {
        display: none;
        text-align: center;
    }

    .file-upload-input {
        position: absolute;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        outline: none;
        opacity: 0;
        cursor: pointer;
    }

    .image-upload-wrap {
        margin-top: 20px;
        border: 2px dashed #949494;
        position: relative;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        background-color: transparent;
        min-height: 18em;
        border-radius: 50%;
    }

    .image-dropping,
    .image-upload-wrap:hover {
        box-shadow: 0 5px 11px 0 rgba(0, 0, 0, 0.15) !important;
        background-color: #f8f6ff;
    }

    .image-title-wrap {
        padding: 0 15px 15px 15px;
        color: #222;
    }

    .drag-text {
        text-align: center;
    }

    .drag-text h5 {
        text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.15);
        margin-top: 4em;
        font-weight: 100;
        color: #828081;
    }
</style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('partials.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('partials.topbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah anda yakin ingin keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "keluar" jika anda yakin untuk mengakhiri sesi saat</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Keluar') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- UbahPasswordModal -->
<div class="modal fade" id="ProfilModal" tabindex="-1" role="dialog" aria-labelledby="modal-formLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="form-role" method="post" class="form-horizontal" data-toggle="validator"
                    enctype="multipart/form-data" autocomplete="off">
                    {{ csrf_field() }} {{ method_field('POST') }}
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-formLabel">Scrolling Long Content Modal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="root">
                        <input type="hidden" id="id" name="id">
                        <div class="form-group row justify-content-center">
                            <label>Gambar</label>
                            <div class="col-md-6 col-12">
                                <div class="file-upload mb-3">
                                    <input type="hidden" name="image_available" value="false" id="image_available">
                                    <div class="image-upload-wrap"
                                        style="background-image: url({{asset('assets/img/attachment-3.jpg')}});">
                                        <div class="box-remove">
                                            <button type="button" onclick="removeUpload()"
                                                class="waves-effect waves-light btn-small red lighten-2">Hapus</button>
                                        </div>
                                        <input name="image" class="file-upload-input" type="file"
                                            onchange="readURL(this);" accept="image/*" />
                                        <div class="drag-text">
                                            <h5>Click or drag an image.
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group">
                            <label>No HP.</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group">
                            <label>No. Rek</label>
                            <input type="text" class="form-control" id="no_rek" name="no_rek">
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group">
                            <label>Password Lama</label>
                            <input type="password" autocomplete="new-password" class="form-control" id="password"
                                name="password">
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password" autocomplete="off" class="form-control" id="password_confirmation"
                                name="password_confirmation">
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group">
                            <label>Konfirmasi Password</label>
                            <input type="password" autocomplete="off" class="form-control" id="password_confirmation"
                                name="password_confirmation">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" onclick="submitEditProfil()s">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
   
    <!-- Bootstrap core JavaScript-->

    <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>
    @yield('js')
    <script>
        const URL = `{{ asset('/') }}`
        function editProfil(id) {
        removeUpload()
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $('#ProfilModal form')[0].reset();
        $.ajax({
            url: "{{ url('dashboard/users') }}" + '/' + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                console.log(data)
                $('#ProfilModal').modal('show');
                $('.modal-title').text('Edit Profil');
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#username').val(data.username);
                $('#no_hp').val(data.no_hp);
                $('#no_rek').val(data.no_rek);
                $('#email').val(data.email);
                if(data.image){
                    $(".image-upload-wrap").css({
                        "background-image": `url(${URL}${data.image})`,
                        border: "0px solid #fff"
                    });
                    $('#image_available').val(true)
                    $(".image-upload-wrap h5").hide();
                    $(".box-remove").css("display", "absolute");
                    $(".box-remove").show();
                    $(".image-title").html(data.image);
                }
            },
            error : function(err) {
                console.log(err)
                alert("Data not found!");
            }
        });
    }

    function removeUpload() {
        $(".file-upload-input").val(null);
        $(".box-remove").hide();
        // $('.image-upload-wrap').show();
        $(".image-upload-wrap").css({
            "background-image": `url(${base_url}/assets/img/attachment-3.jpg)`,
            border: "2px dashed #949494"
        });
        $('#image_available').val(false)
        $(".image-upload-wrap h5").show();
    }
    
    </script>
    
</body>

</html>