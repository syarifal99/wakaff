@extends('layouts.master')
@section('title')
Mitra
@endsection

@section('content')
<style>
    .image-upload-wrap {
  border-radius: 0 !important;}
</style>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">Management Mitra</h1>
    <div class="btn-group btn-group-md">
        <button onclick="addForm()" class="btn btn-primary">Tambahkan mitra</button>
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
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Mitra</h6>
                        </div>
                        <div class="btn-group btn-group-md">
                            <button type="button" class="btn btn-outline-success btn-sm" id="btn-refresh"
                                title="Refresh data"><i class="fas fa-sync-alt"></i></button>
                        </div>
                    </div>
                    <table id="mitra-table" class="table table-striped table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Logo</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Nama PJ</th>
                                <th>Email</th>
                                <th>No. HP</th>
                                <th>No. Rek</th>
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
                            <label>PJ</label>
                            <input type="text" class="form-control" id="pj" name="pj" required>
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
                            <label>Password</label>
                            <input type="password" autocomplete="new-password" class="form-control" id="password"
                                name="password">
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group">
                            <label>Password Confirmation</label>
                            <input type="password" autocomplete="off" class="form-control" id="password_confirmation"
                                name="password_confirmation">
                            <span class="help-block with-errors"></span>
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
            $('#mitra-table').DataTable().draw(true)
        })
        var table = $('#mitra-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            scrollX: true,
            ajax: "{{ route('api.mitra') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'show_image', name: 'show_image'},
                {data: 'name', name: 'name'},
                {data: 'username', name: 'username'},
                {
                    data: null, orderable: false, width: '100px',
                    render: function (data) {
                        if(!data.mitra_attr) return '-'
                        return data.mitra_attr.pj
                    }
                },
                {data: 'email', name: 'email'},
                {
                    data: null, orderable: false, width: '100px',
                    render: function (data) {
                        if(!data.no_hp) return '-'
                        return data.no_hp
                    }
                },
                {
                    data: null, orderable: false, width: '100px',
                    render: function (data) {
                        if(!data.no_rek) return '-'
                        return data.no_rek
                    }
                },
                {data: 'action', name: 'action', orderable: false, searchable: false}
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
                if (save_method == 'add') url = "{{ url('dashboard/mitra') }}";
                else url = "{{ url('dashboard/mitra') . '/' }}" + id;

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
    
    function addForm() {
        removeUpload()
        save_method = "add";
        $('input[name=_method]').val('POST');
        $('#modal-form').modal('show');
        $('#modal-form form')[0].reset();
        $('.modal-title').text('Add mitra');
    }

    function editForm(id) {
        removeUpload()
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $('#modal-form form')[0].reset();
        $.ajax({
            url: "{{ url('dashboard/mitra') }}" + '/' + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                console.log(data)
                $('#modal-form').modal('show');
                $('.modal-title').text('Edit mitra');

                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#username').val(data.username);
                $('#pj').val(data.mitra_attr.pj);
                $('#no_hp').val(data.no_hp);
                $('#no_rek').val(data.no_rek);
                $('#email').val(data.email);
                if(data.image){
                    $(".image-upload-wrap").css({
                        "background-image": `url(${data.image})`,
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
                url : "{{ url('dashboard/mitra') }}" + '/' + id,
                type : "POST",
                data : {'_method' : 'DELETE', '_token' : csrf_token},
                success : function(data) {
                    $('#mitra-table').DataTable().draw(true);
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