@extends('layouts.master')
@section('title')
Pencairan Dana
@endsection

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h5 class="h4 mb-0 text-gray-800">Manajemen Update Progres Projek</h5>
</div>

<!-- Content Row -->
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="btn-group btn-group-md">
                            <h6 class="m-0 font-weight-bold text-success">Data Pencairan Dana</h6>
                        </div>
                        <div class="btn-group btn-group-md">
                            <button type="button" class="btn btn-outline-success btn-sm" id="btn-refresh"
                                title="Refresh data"><i class="fas fa-sync-alt"></i></button>
                        </div>
                    </div>
                    <table id="pencairan-table" class="table table-striped table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Projek</th>
                                <th>Nominal</th>
                                <th>Deskripsi</th>
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
                        </div>
                        <div class="form-group">
                            <label for="projek_id">Projek</label>
                            <select class="form-control" id="projek_id" placeholder="Pilih projek" name="projek_id">
                                <option value="" disabled>-- Pilih projek --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nominal</label>
                            <input type="text" class="form-control" id="nominal" name="nominal" required>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" required>
                            <span class="help-block with-errors"></span>
                        </div>
                        @hasanyrole('admin|superadmin')
                        <div class="form-mitra"></div>
                        <div class="form-validasi">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" placeholder="Pilih status" name="status">
                                    <option value="" disabled>-- Pilih status --</option>
                                    <option value="MENUNGGU">MENUNGGU</option>
                                    <option value="DISETUJUI">DISETUJUI</option>
                                    <option value="DITOLAK">DITOLAK</option>
                                </select>
                            </div>
                        </div>
                        @endhasanyrole
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
{{-- Datatable --}}
<script src="{{asset('assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
{{-- Validator --}}
<script src="{{ asset('assets/vendor/validator/validator.min.js') }}"></script>
<script type="text/javascript">
    let _roles = {}
    let _permissions = {}
    $(document).ready(function() {
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

        $(document).on('click', '.btn_status', function(){
            let id = $(this).data('id')
            let status = $(this).data('status')
            let url = "{{url('dashboard/api-pencairan'). '/'}}" + id + "/update-status"
            let csrf_token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url : url,
                type : "POST",
                data: {
                    _token: csrf_token,
                    status: status
                },
                success : function(data) {
                    console.log(data)
                    table.ajax.reload();
                    swal({
                        title: 'Sukses',
                        text: data.message,
                        type: 'success',
                        timer: '1500'
                    })
                },
                error : function(err){ console.log(err) }
            });
        })

        $('#btn-refresh').on('click', function(){
            $('#pencairan-table').DataTable().draw(true)
        })
        var table = $('#pencairan-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            scrollX: true,
            ajax: "{{ route('api.pencairan') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'projek.nama', name: 'projek.nama'},
                {data: 'nominal_uang', name: 'nominal_uang'},
                {data: 'deskripsi', name: 'deskripsi'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        $('#modal-form form').validator().on('submit', function (e) {
            if (!e.isDefaultPrevented()){
                var id = $('#id').val();
                if (save_method == 'add') url = "{{ url('dashboard/pencairan') }}";
                else url = "{{ url('dashboard/pencairan') . '/' }}" + id;

                $.ajax({
                    url : url,
                    type : "POST",
                    //hanya untuk input data tanpa dokumen
//                      data : $('#modal-form form').serialize(),
                    data: new FormData($("#modal-form form")[0]),
                    contentType: false,
                    processData: false,
                    success : function(data) {
                        console.log(data)
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                        swal({
                            title: 'Sukses',
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
                            title: 'Maaf...',
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
    
    function addForm() {
        removeUpload()
        save_method = "add";
        $('input[nama=_method]').val('POST');

        $.ajax({
            url : "{{ route('project.getAll') }}" ,
            type : "GET",
            success: function(res){
                console.log(res)

                $("#projek_id").empty();
                $("#projek_id").append(`<option value="" selected disabled>-- Pilih Projek --</option>`);
                $.each(res, function(key, item) {
                    $("#projek_id").append(`<option value="` + item.id + `">` + item.nama +` </option>`);
                });

            }, error: function(error){
                console.log(error);
            }
        });

        $('#modal-form').modal('show');
        $('#modal-form form')[0].reset();
        $('.modal-title').text('Add pencairan');
    }

    function editForm(id) {
        removeUpload()
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $('#modal-form form')[0].reset();

        $.ajax({
            url : "{{ route('project.getAll') }}" ,
            type : "GET",
            success: function(res){
                console.log(res)

                $("#projek_id").empty();
                $("#projek_id").append(`<option value="" selected disabled>-- Pilih Projek --</option>`);
                $.each(res, function(key, item) {
                    $("#projek_id").append(`<option value="` + item.id + `">` + item.nama +` </option>`);
                });

            }, error: function(error){
                console.log(error);
            }
        });
        $.ajax({
            url : "{{ route('project.getAll') }}" ,
            type : "GET",
            async: false,
            success: function(res){
                console.log(res)

                $("#projek_id").empty();
                $("#projek_id").append(`<option value="" selected disabled>-- Pilih Projek --</option>`);
                $.each(res, function(key, item) {
                    $("#projek_id").append(`<option value="` + item.id + `">` + item.nama +` </option>`);
                });

            }, error: function(error){
                console.log(error);
            }
        });
        $.ajax({
            url: "{{ url('dashboard/pencairan') }}" + '/' + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                pencairan = data
                console.log(data)
                $('#modal-form').modal('show');
                $('.modal-title').text('Edit pencairan');

                $('#id').val(data.id);
                $('#nominal').val(data.nominal);
                $('#deskripsi').val(data.deskripsi);
                $("#projek_id").val(data.projek_id);
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
            title: 'Apakah anda yakin?',
            text: "Anda tidak akan dapat kembali!",
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Iya, hapus!'
        }).then(function () {
            $.ajax({
                url : "{{ url('dashboard/pencairan') }}" + '/' + id,
                type : "POST",
                data : {'_method' : 'DELETE', '_token' : csrf_token},
                success : function(data) {
                    $('#pencairan-table').DataTable().draw(true);
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
    let base_url = "{{url('/')}}"
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