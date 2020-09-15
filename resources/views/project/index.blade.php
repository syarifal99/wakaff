@extends('layouts.master')
@section('title')
Project
@endsection

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">Daftar Projek</h1>
    <div class="btn-group btn-group-md">
        <button onclick="addForm()" class="btn btn-primary">Tambahkan project</button>
    </div>
</div>

<!-- Content Row -->
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="btn-group btn-group-md">
                            <h6 class="m-0 font-weight-bold text-success">Daftar Project</h6>
                        </div>
                        <div class="form-group">
                            <select name="" id="kategori_wakaf" class="form-control">
                                <option value="">Semua</option>
                                <option value="2">Wakaf Tunai</option>
                                <option value="1">Wakaf Aset</option>
                            </select>
                        </div>
                        <div class="btn-group btn-group-md">
                            <button type="button" class="btn btn-outline-success btn-sm" id="btn-refresh"
                                title="Refresh data"><i class="fas fa-sync-alt"></i></button>
                        </div>
                    </div>
                    <table id="projek-table" class="table table-striped table-bordered"width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Nama Project</th>
                                <th>Kategori</th>
                                <th>Label</th>
                                <th>Tenggat Waktu</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-formLabel"
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
                            <label>Image</label>
                            <div class="col-md-6 col-12">
                                <div class="file-upload mb-3">
                                    <input type="hidden" name="image_available" value="false" id="image_available">
                                    <div class="image-upload-wrap"
                                        style="background-image: url({{asset('assets/img/attachment-3.jpg')}});">
                                        <div class="box-remove">
                                            <button type="button" onclick="removeUpload()"
                                                class="btn btn-danger btn-sm">Remove</button>
                                        </div>
                                        <input name="gambar" class="file-upload-input" type="file"
                                            onchange="readURL(this);" accept="gambar/*" />
                                        <div class="drag-text">
                                            <h5>Click or drag an image.
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nama Project</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group">
                            <label for="kategori_id">Kategori</label>
                            <select class="form-control" id="kategori_id" placeholder="Pilih kategori" name="kategori_id">
                                <option value="" selected disabled>-- Pilih kategori --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="label_id">Label</label>
                            <select class="form-control" id="label_id" placeholder="Pilih label" name="label_id">
                                <option value="" selected disabled>-- Pilih label --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nominal</label>
                            <input type="text" class="form-control" id="nominal" name="nominal" required>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group">
                            <label for="tenggat_waktu Waktu">Tenggat Waktu</label>
                            <input type="date" class="@error('nominal') is-invalid @enderror form-control" id="tenggat_waktu" name="tenggat_waktu">
                            @error('tenggat_waktu')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="provinsi_id">Provinsi</label>
                            <select class="form-control" id="provinsi_id" name="provinsi_id">
                                <option value="">-- Pilih provinsi --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kota">Kota</label>
                            <select class="form-control" id="kota_id" placeholder="Pilih kota" name="kota_id">
                                <option value="" seleced disabled>-- Pilih Kota --</option>
                            </select>
                        </div>
                        <div class="form-group" id="form_jenis">
                            <label for="jenis">Jenis</label>
                            <select class="js-example-placeholder-multiple js-states form-control" multiple="multiple" id="jenis" name="jenis[]"></select>
                        </div>
                        @hasanyrole('admin|superadmin')
                        <div class="form-mitra"></div>
                        <div class="form-validasi">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" placeholder="Pilih status" name="status">
                                    <option value="" selected disabled>-- Pilih status --</option>
                                    <option value="MENUNGGU">MENUNGGU</option>
                                    <option value="DISETUJUI">DISETUJUI</option>
                                    <option value="DITOLAK">DITOLAK</option>
                                </select>
                            </div>
                        </div>
                        @endhasanyrole
                        <!-- {{-- <div class="form-group">
                            <label>Password Confirmation</label>
                            <input type="password" autocomplete="off" class="form-control" id="password_confirmation"
                                name="password_confirmation">
                            <span class="help-block with-errors"></span>
                        </div> --}} -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('css')
<link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
<link rel="stylesheet" href="https://select2.github.io/select2-bootstrap-theme/css/select2-bootstrap.css" />
<style>
    .image-upload-wrap {
  border-radius: 0 !important;}
</style>
@endsection
@section('js')
<script src="{{asset('js/select2.min.js')}}"></script>
{{-- Datatable --}}
<script src="{{asset('assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
{{-- Validator --}}
<script src="{{ asset('assets/vendor/validator/validator.min.js') }}"></script>
<script type="text/javascript">
    let _roles = {}
    let _permissions = {}
    const URL = `{{ asset('/') }}`
    
    $(document).ready(function() {
        $('#jenis').select2({
            allowClear: true,
            placeholder: "-- Masukkan Jenis --",
            tags:true,
            width: '100%',
            dropdownAutoWidth: true,
        });
        var table = showData()
        // let title = ''
        // let slug = ''
        // const app = new Vue({
        //     el: '#root',
        //     data: {
        //         title: title,
        //         slug: slug
        //     },
            
        //     watch: {
        //         title: function(val) {
        //             this.slug = Slugify(val)
        //         }
        //     }
        // })
        $(document).on("change", "#kategori_id", function() {
            if ($(this).val()==1){    
                $('#nominal').attr('placeholder', 'Masukkan unit');
                $('#labelNominal').text('Unit');
            }else {
                $('#nominal').attr('placeholder', 'Masukkan nominal');
                $('#labelNominal').text('Nominal');
            }        
        })
        $(document).on("change", "#provinsi_id", function() {
            let id = $(this).val()
            if(!id) return false;
            $.ajax({
                url : "{{ url('provinsi') . '/' }}" + id,
                type : "GET",
                success: function(res){
                    $("#kota_id").empty();
                    $("#kota_id").append(`<option value="" selected disabled>-- Pilih kota --</option>`);
                    $.each(res.kota, function(key, item) {
                        $("#kota_id").append(`<option value="` + item.id + `">` + item.kota +` </option>`);
                    });
                }, error: function(error){
                    console.log(error);
                }
            });
        });
        $('#btn-refresh').on('click', function(){
            $('#projek-table').DataTable().draw(true)
        })
        // showData()

        $(document).on('change', '#kategori_wakaf', () => {
            id = $('#kategori_wakaf').val()
            // $('#projek-table').DataTable().fnDestroy()
            $('#projek-table').dataTable().fnClearTable();
            $('#projek-table').dataTable().fnDestroy();
            showData(id)
        })

        $(document).on('change', '#kategori_id', () => {
            id = $('#kategori_id').val()
            const form = $('#form_jenis')
            if(id == 1) {
                form.show()
            } else {
                form.hide()
            }
        })

        $('#projek-table').DataTable().on('order.dt search.dt', function () {
            $('#projek-table').DataTable().column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

        $('#modal-form form').validator().on('submit', function (e) {
            if (!e.isDefaultPrevented()){
                var id = $('#id').val();
                if (save_method == 'add') url = "{{ route('project.store') }}";
                else url = "{{ url('dashboard/project') . '/' }}" + id;
                $.ajax({
                    url : url,
                    type : "POST",
                    //hanya untuk input data tanpa dokumen
//                      data : $('#modal-form form').serialize(),
                    data: new FormData($("#modal-form form")[0]),
                    contentType: false,
                    processData: false,
                    success : function(data) {
                        $('#modal-form').modal('hide');
                        $('#projek-table').DataTable().ajax.reload();
                        swal({
                            title: 'Success!',
                            text: data.message,
                            type: 'success',
                            timer: '1500'
                        })
                    },
                    error : function(data){
                        console.log(data)
                        var response = JSON.parse(data.responseText);
                        let str = ''
                        $.each(response.errors, function(key, value) {
                            str += value + ', ';
                        });
                        swal({
                            title: 'Punten🙏🏻...',
                            text: str,
                            type: 'error',
                            timer: '1500'
                        })
                    }
                });
                return false;
            }
        });
    } );

    async function showData(kategori_id = ''){
        table = await $('#projek-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            scrollX: true,
            ajax: {
                url: "{{ route('api.project') }}",
                method: "GET",
                data: {
                    q: kategori_id
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'show_image', name: 'show_image'},
                {data: 'nama', name: 'nama'},
                {data: 'kategori.kategori', name: 'kategori.kategori'},
                {data: 'label.label', name: 'label.label'},
                {data: 'tenggat_waktu', name: 'tenggat waktu'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    }
    
    function validasi(id){
        let url =  "{{ url('dashboard/project/validasi') }}/" + id 
        $.ajax({
            url: "{{ url('dashboard/project') }}" + '/' + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-form').modal('show');
                $('.modal-title').text('Edit Projek');
                // $('#projek_id').val(data.user.projek_attr.id);
                
            },
            error : function(err) {
                console.log(err)
                alert("Data not found!");
            }
        });
        $.ajax({
            url : url,
            type : "GET",
            success: function(res){
                $('#projek-table').DataTable().draw(true)
                swal({
                    title: 'Success!',
                    text: res.message,
                    type: 'success',
                    timer: '1500'
                })
            }, error: function(error){
                console.log(error);
                swal({
                    title: 'Punten🙏🏻...',
                    text: error.message,
                    type: 'error',
                    timer: '1500'
                })
            }
        });
    }
    
    function addForm() {
        removeUpload()
        save_method = "add";
        $('input[name=_method]').val('POST');
        $.ajax({
            url : "{{ route('kategori.index') }}" ,
            type : "GET",
            async: false,
            success: function(res){
                console.log(res)
                $("#kategori_id").empty();
                $("#kategori_id").append(`<option value="" selected disabled>-- Pilih kategori --</option>`);
                $.each(res, function(key, item) {
                    $("#kategori_id").append(`<option value="` + item.id + `">` + item.kategori +` </option>`);
                });
            }, error: function(error){
                console.log(error);
            }
        });
        $.ajax({
            url : "{{ route('label.index') }}" ,
            type : "GET",
            async: false,
            success: function(res){
                console.log(res)
                $("#label_id").empty();
                $("#label_id").append(`<option value="" selected disabled>-- Pilih label --</option>`);
                $.each(res, function(key, item) {
                    $("#label_id").append(`<option value="` + item.id + `">` + item.label +` </option>`);
                });
            }, error: function(error){
                console.log(error);
            }
        });
        $.ajax({
            url : "{{ route('provinsi.index') }}" ,
            type : "GET",
            async: false,
            success: function(res){
                console.log(res)
                $("#provinsi_id").empty();
                $("#provinsi_id").append(`<option value="" selected disabled>-- Pilih provinsi --</option>`);
                $.each(res, function(key, item) {
                    $("#provinsi_id").append(`<option value="` + item.id + `">` + item.provinsi +` </option>`);
                });
            }, error: function(error){
                console.log(error);
            }
        });
        $('#modal-form').modal('show');
        $('#modal-form form')[0].reset();
        $('.modal-title').text('Add Projek');
    }
    function editForm(id) {
        removeUpload()
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $('#modal-form form')[0].reset();
        $.ajax({
            url : "{{ route('kategori.index') }}" ,
            type : "GET",
            async: false,
            success: function(res){
                console.log(res)
                $("#kategori_id").empty();
                $("#kategori_id").append(`<option value="" selected disabled>-- Pilih kategori --</option>`);
                $.each(res, function(key, item) {
                    $("#kategori_id").append(`<option value="` + item.id + `">` + item.kategori +` </option>`);
                });
            }, error: function(error){
                console.log(error);
            }
        });
        $.ajax({
            url : "{{ route('label.index') }}" ,
            type : "GET",
            async: false,
            success: function(res){
                console.log(res)
                $("#label_id").empty();
                $("#label_id").append(`<option value="" selected disabled>-- Pilih label --</option>`);
                $.each(res, function(key, item) {
                    $("#label_id").append(`<option value="` + item.id + `">` + item.label +` </option>`);
                });
            }, error: function(error){
                console.log(error);
            }
        });
        $.ajax({
            url : "{{ route('provinsi.index') }}" ,
            type : "GET",
            async: false,
            success: function(res){
                console.log(res)
                $("#provinsi_id").empty();
                $("#kota_id").empty();
                $("#provinsi_id").append(`<option value="" selected disabled>-- Pilih provinsi --</option>`);
                $("#kota_id").append(`<option value="" selected disabled>-- Pilih kota --</option>`);
                $.each(res, function(key, item) {
                    $("#provinsi_id").append(`<option value="` + item.id + `">` + item.provinsi +` </option>`);
                    $.each(item.kota, function(key, kota) {
                        $("#kota_id").append(`<option value="` + kota.id + `">` + kota.kota +` </option>`);
                    });
                });
            }, error: function(error){
                console.log(error);
            }
        });
        $.ajax({
            url: "{{ url('dashboard/project') }}" + '/' + id ,
            type: "GET",
            dataType: "JSON",
            async: false,
            success: function(data) {
                console.log(data)
                $('#modal-form').modal('show');
                $('.modal-title').text('Edit projek');
                
                $('#id').val(data.projek.id);
                $('#nama').val(data.projek.nama);
                $('#kategori_id').val(data.projek.kategori.id).trigger('change');
                $('#label_id').val(data.projek.label.id);
                $('#nominal').val(data.projek.nominal);
                $('#tenggat_waktu').val(data.projek.tenggat_waktu);
                $('#provinsi_id').val(data.projek.kota.provinsi.id);
                $('#kota_id').val(data.projek.kota.id);

                let jenis = []
                let strJenis = "";
                data.projek.jenis.forEach(el => {
                    strJenis += `<option value="${el.jenis}">${el.jenis}</option>`
                    jenis.push(el.jenis)
                });
                $('#jenis').html(strJenis)
                $('#jenis').val(jenis).trigger('change');
                
                if(data.projek.gambar){
                    $(".image-upload-wrap").css({
                        "background-image": `url(${URL}${data.projek.gambar})`,
                        border: "0px solid #fff"
                    });
                    $('#image_available').val(true)
                    $(".image-upload-wrap h5").hide();
                    $(".box-remove").css("display", "absolute");
                    $(".box-remove").show();
                    $(".image-title").html(data.projek.gambar);
                }
                let str = ''
                str += `<div class="form-group">
                            <label for="mitra_id">Mitra</label>
                            <select class="form-control" id="mitra_id" placeholder="Pilih mitra_id" name="mitra_id">
                                <option value="">-- Pilih mitra --</option>`
                $.each(data.mitra, (key, val)=>{
                    let isMitra = val.mitra_attr.id == data.projek.mitra_id?'selected': ''
                    str += `<option value="${val.mitra_attr.id}" ${isMitra}>${val.name}</option>`
                })
                str += `</select>
                    </div>`
                let str2 = `<div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" placeholder="Pilih status" name="status">
                            <option value="" disabled>-- Pilih status --</option>
                            <option value="MENUNGGU">MENUNGGU</option>
                            <option value="DISETUJUI">DISETUJUI</option>
                            <option value="DITOLAK">DITOLAK</option>
                        </select>
                    </div>
                    `
                $('.form-mitra').html(str)
                $('.form-validasi').html(str2)
                $('#status').val(data.projek.status)
            },
            error : function(err) {
                console.log(err)
                alert("Data not found!");
            }
        });
    }
    function deleteData(id){
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then(function () {
            $.ajax({
                url : "{{ url('dashboard/project') }}" + '/' + id,
                type : "POST",
                data : {'_method' : 'DELETE', '_token' : csrf_token},
                success : function(data) {
                    $('#projek-table').DataTable().draw(true);
                    swal({
                        title: 'Success!',
                        text: data.message,
                        type: 'success',
                        timer: '1500'
                    })
                },
                error : function (data) {
                    console.log(data)
                    swal({
                        title: 'Oops...',
                        text: data.message,
                        type: 'error',
                        timer: '1500'
                    })
                }
            });
        });
    }
    function initRoles(){
        $.ajax({
            url: "{{ url('dashboard/roles') }}",
            type: "GET",
            async: false,
            dataType: "JSON",
            success: function(roles) {
                _roles = roles
                let str = ''
                $.each(roles, (k,v)=>{
                    str += `<div class="col m6 s12">
                                <p>
                                    <label style="color:#000 !important;">
                                        <input type="checkbox" class="cb_role filled-in" id="${v.id}" value="${v.name}"/>
                                        <span>${v.name}</span>
                                    </label>
                                </p>
                            </div>`
                })
                // onclick="return false;"
                $('.roles').html(str)
            },
            error : function(err) {
                console.log(err)
                alert("Data not found!");
            }
        });
    }
    function initPermissions(){
        $.ajax({
            url: "{{ url('permissions') }}",
            type: "GET",
            async: false,
            dataType: "JSON",
            success: function(permissions) {
                _permissions = permissions
                let str = ''
                $.each(permissions, (k,v)=>{
                    str += `<div class="col m6 s12">
                                <p>
                                    <label style="color:#000 !important;">
                                        <input type="checkbox" class="cb_permission filled-in" id="${v.id}" value="${v.name}"/>
                                        <span>${v.name}</span>
                                    </label>
                                </p>
                            </div>`
                })
                $('.permissions').html(str)
            },
            error : function(err) {
                console.log(err)
                alert("Data not found!");
            }
        });
    }
    const base_url = "{{url('/')}}"
    function readURL(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                // $('.image-upload-wrap').hide();
                $(".image-upload-wrap").css({
                    "background-image": `url(${e.target.result})`,
                    border: "0px solid #fff"
                });
                $(".image-upload-wrap h5").hide();
                $('.file-upload-input').attr('src', e.target.result);
                $(".box-remove").css("display", "absolute");
                $(".box-remove").show();
                $(".image-title").html(input.files[0].name);
            };
            $('#image_available').val(true)
            reader.readAsDataURL(input.files[0]);
        } else {
            $(".image-upload-wrap").css({
                "background-image": `url(${base_url}/assets/img/attachment-3.jpg)`,
                border: "2px dashed #949494"
            });
            $('#image_available').val(false)
            $(".image-upload-wrap h5").show();
            $(".box-remove").hide();
        }
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
@endsection