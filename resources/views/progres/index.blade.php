@extends('layouts.master')
@section('title')
Progres Project
@endsection

@section('content')

<!-- Content Row -->
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="btn-group btn-group-md">
                            <h6 class="m-0 font-weight-bold text-success">Data Progres Project</h6>
                        </div>
                        <div class="btn-group btn-group-md">
                            <button type="button" class="btn btn-outline-success btn-sm" id="btn-refresh"
                                title="Refresh data"><i class="fas fa-sync-alt"></i></button>
                        </div>
                    </div>
                    @foreach ($progres as $p)
                    <div class="card border-left-info shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                          <h6 class="m-0 font-weight-bold text-primary" id="nama_project">{{$p['progres']->nama}}</h6>
                          <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                              aria-haspopup="true" aria-expanded="false">
                              <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                              aria-labelledby="dropdownMenuLink">
                              <div class="dropdown-header">Request:</div>
                              <a class="dropdown-item" onclick="addForm({{$p['progres']->id}})">Pencairan Dana</a>
                              <div class="dropdown-divider"></div>
                              <div class="dropdown-header">Master Data:</div>
                              <a class="dropdown-item" href="pencairan/mitra/{{$p['progres']->id}}">Daftar Pencairan Dana</a>
                            </div>
                          </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body">
                          <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="float:left; width: 12rem;"
                            src="{{asset($p['progres']->gambar)}}" alt="">
                          <div class="row">
                              <div class="col-md-6">
                                    <strong>Dana yang masuk: </br></strong>
                                    <p>Rp. {{number_format($p['dana_terkumpul'])}}</p>
                                    <strong>Dana yang telah dicairkan : </br></strong>
                                    <p>Rp. {{number_format($p['dana_pencairan'])}}</p>
                              </div>
                              <div class="col-md-6">
                                    <strong>Target Dana: </br></strong>
                                    <p>Rp. {{number_format($p['progres']->nominal)}}</p>
                                    <strong>Dana Sisa: </br></strong>
                                    <p>Rp. {{number_format($p['dana_terkumpul'] - $p['dana_pencairan'])}}</p>
                              </div>
                          </div>
                          <a href="kabar/{{$p['progres']->id}}" class="btn d-sm-inline-block btn-info btn-user btn-block">
                            Kabar Project
                          </a>
                        </div>
                    </div>
                    @endforeach

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
                        <input type="hidden" id="projek_id" name="projek_id" value="">
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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


        $('#btn-refresh').on('click', function(){
            $('#pencairan-table').DataTable().draw(true)
        })
        $('#nama_project').text(data.projek.nama.length)
        var table = $('#pencairan-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            scrollX: true,
            ajax: "{{ route('api.pencairan') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'projek.nama', name: 'projek.nama'},
                {data: 'nominal', name: 'nominal'},
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

    function addForm(id = null) {
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
        $("#projek_id").val(id)
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
