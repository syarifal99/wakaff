@extends('layouts.master')
@section('title')
Pendanaan
@endsection

@section('content')
<!-- Page Heading -->
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h5>Pendanaan Management</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                {{-- <div class="card-header">
                    <h4>Pendanaan Management</h4>
                </div> --}}
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="btn-group btn-group-md">
                            <h6 class="m-0 font-weight-bold text-success">Data Dana Masuk</h6>
                        </div>
                        <div class="btn-group btn-group-md">
                            <button type="button" class="btn btn-outline-success btn-sm" id="btn-refresh"
                                title="Refresh data"><i class="fas fa-sync-alt"></i></button>
                        </div>
                    </div>
                    <table id="pendanaan-table" class="table table-striped table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                @if(Auth::user()->getRoleNames()->first() == 'admin')
                                    <th>No.</th>
                                    <th>Nama Projek</th>
                                    <th>Nama Pendaftar</th>
                                    <th>Nominal</th>
                                    <th>Metode</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                @else
                                    <th>No.</th>
                                    <th>Nama Projek</th>
                                    <th>Total Jumlah Pendaftar</th>
                                    <th>Total Dana Masuk</th>
                                    <th>Target Nominal</th>
                                    <th>Aksi</th>
                                @endif
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
                            <img src="" alt="" id='bukti' class='img-fluid img-thumbnail' width="400">
                        </div>
                        <div class="form-group">
                            <label for="projek_id">Projek</label>
                            <select class="form-control" id="projek_id" placeholder="Pilih projek" name="projek_id"  readonly>
                                <option value="" disabled>-- Pilih projek --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" id="name" name="name" readonly>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group">
                            <label>Nominal</label>
                            <input type="text" class="form-control" id="nominal" name="nominal" readonly>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group">
                                <label for="metode">Metode</label>
                                <input type="text" class="form-control" id="metode" name="metode" readonly>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan" readonly>
                            <span class="help-block with-errors"></span>
                        </div>
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
            $('#pendanaan-table').DataTable().draw(true)
        })
        var table = $('#pendanaan-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            scrollX: true,
            @if(Auth::user()->getRoleNames()->first() == 'admin')
            ajax: "{{ route('api.pendanaan.admin') }}",
            @else
            ajax: "{{ route('api.pendanaan') }}",
            @endif
            columns: [
                @if(Auth::user()->getRoleNames()->first() == 'admin')
                    {data: 'projek.id', name: 'projek.id'},
                    {data: 'projek.nama', name: 'projek.nama'},
                    {data: 'user.name', name: 'user.name'},
                    {data: 'nominal_uang', name: 'nominal_uang'},
                    {data: 'metode', name: 'metode'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                @else
                    {data: 'projek.id', name: 'projek.id'},
                    {data: 'projek.nama', name: 'projek.nama'},
                    {data: 'total_user', name: 'total_user'},
                    {data: 'total_pendanaan', name: 'total_pendanaan'},
                    {data: 'projek.nominal_uang', name: 'projek.nominal_uang'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                @endif
            ]
        });



        table.on('order.dt search.dt', function () {
            table.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

        $('#modal-form form').validator().on('submit', function (e) {
            if (!e.isDefaultPrevented()){
                var id = $('#id').val();
                if (save_method == 'add') url = "{{ url('dashboard/pendanaan') }}";
                else url = "{{ url('dashboard/pendanaan') . '/' }}" + id;

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
            url: "{{ url('dashboard/pendanaan') }}" + '/' + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                console.log("sa")
                console.log(data)
                $('#modal-form').modal('show');
                $('.modal-title').text('Edit pendanaan');
                let url = '{{ url('/') }}'
                $('#id').val(data.id);
                $('#bukti').attr("src",`${url}${data.bukti}`);
                $('#user_id').val(data.name);
                $('#name').val(data.user.name);
                $('#nominal').val(data.nominal);
                $('#metode').val(data.metode);
                $('#keterangan').val(data.keterangan);
                $('#status').val(data.status);
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
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then(function () {
            $.ajax({
                url : "{{ url('dashboard/pendanaan') }}" + '/' + id,
                type : "POST",
                data : {'_method' : 'DELETE', '_token' : csrf_token},
                success : function(data) {
                    $('#pendanaan-table').DataTable().draw(true);
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
