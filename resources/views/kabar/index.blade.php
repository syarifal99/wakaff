@extends('layouts.master')
@section('title')
Mitra
@endsection

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kabar Terbaru</h1>
    <div class="btn-group btn-group-md">
        <button onclick="addForm()" class="btn btn-success">Tambahkan Kabar</button>
    </div>
</div>

<!-- Content Row -->
{{-- <div class="content">
    @forelse ($kabar as $k)
    <!-- Collapsable Card Example -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
        <h6 class="m-0 font-weight-bold text-success">{{$k->judul}}</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse show" id="collapseCardExample">
        <div class="card-body">
            {{$k->konten}}
        </div>
        </div>
    </div>
    @empty
    @endforelse
</div> --}}

<div class="content">
    @forelse ($kabar as $k)
    <!-- Collapsable Card Example -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
               <div class="collapse show" id="collapseCardExample">
                <div class="card-body">
                  <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="float:left; width: 10rem;"
                    src="{{$k->gambar}}" alt="" width="500">
                  <h4 class="m-0 font-weight-bold text-primary">{{$k->judul}}</h4>
                  {{$k->created_at}} <br><br>
                  {!!$k->konten!!}
                  <p style="text-align:right;">
                    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Selengkapnya</a>
                  </p>
                </div>
              </div>
    </div>
    @empty
        Belum ada kabar
    @endforelse
    <div class="text-content-center">

    {!! $kabar->links() !!}
    </div>
</div>

<!-- Content Row -->
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            {{-- <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="btn-group btn-group-md">
                            <h6 class="m-0 font-weight-bold text-success">Data Kabar</h6>
                        </div>
                        <div class="btn-group btn-group-md">
                            <button onclick="addForm()" class="btn btn-success">Tambahkan Kabar</button>
                        </div>
                        <div class="btn-group btn-group-md">
                            <button type="button" class="btn btn-outline-success btn-sm" id="btn-refresh"
                                title="Refresh data"><i class="fas fa-sync-alt"></i></button>
                        </div>
                    </div>
                    <table id="kabar-table" class="table table-striped table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Gambar</th>
                                <th>Projek</th>
                                <th>judul</th>
                                <th>Konten</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div> --}}
        </div>
    </div>

    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-formLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{route('kabar.store')}}" id="form-role" method="POST" class="form-horizontal" data-toggle="validator"
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
                                                class="btn btn-danger btn-sm">Hapus</button>
                                        </div>
                                        <input name="gambar" class="file-upload-input" type="file"
                                            onchange="readURL(this);" accept="gambar/*" />
                                        <div class="drag-text">
                                            <h5>Klik atau geser gambar.
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="projek_id" value="{{$id}}">
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" class="form-control" id="judul" name="judul" required>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group">
                            <label>Konten</label>
                            <br>
                            <textarea name="konten" id="konten"></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
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
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('konten', {
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}'
    });
</script>
<style>
    .image-upload-wrap {
  border-radius: 0 !important;}
</style>
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
            $('#kabar-table').DataTable().draw(true)
        })
        // var table = $('#kabar-table').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     responsive: true,
        //     scrollX: true,
        //     ajax: "{{ route('api.kabar') }}",
        //     columns: [
        //         {data: 'id', name: 'id'},
        //         {data: 'show_image', name: 'show_image'},
        //         {data: 'projek.nama', name: 'projek.nama'},
        //         {data: 'judul', name: 'judul'},
        //         {data: 'konten', name: 'konten'},
        //         {data: 'action', name: 'action', orderable: false, searchable: false}
        //     ]
        // });
        $('#modal-form form').validator().on('submit', function (e) {
            if (!e.isDefaultPrevented()){
                var id = $('#id').val();
                if (save_method == 'add') url = "{{ url('dashboard/kabar') }}";
                else url = "{{ url('dashboard/kabar') . '/' }}" + id;
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
                            title: 'Sukses!',
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
        $('.modal-title').text('Tambah kabar');
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
            url: "{{ url('dashboard/kabar') }}" + '/' + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                console.log(data)
                $('#modal-form').modal('show');
                $('.modal-title').text('Ubah kabar');
                $('#id').val(data.id);
                $('#judul').val(data.judul);
                $('#konten').val(data.konten);
                if(data.gambar){
                    $(".image-upload-wrap").css({
                        "background-image": `url(${data.gambar})`,
                        border: "0px solid #fff"
                    });
                    $('#image_available').val(true)
                    $(".image-upload-wrap h5").hide();
                    $(".box-remove").css("display", "absolute");
                    $(".box-remove").show();
                    $(".image-title").html(data.gambar);
                }
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
                url : "{{ url('dashboard/kabar') }}" + '/' + id,
                type : "POST",
                data : {'_method' : 'DELETE', '_token' : csrf_token},
                success : function(data) {
                    $('#kabar-table').DataTable().draw(true);
                    swal({
                        title: 'Sukses!',
                        text: data.message,
                        type: 'success',
                        timer: '1500'
                    })
                },
                error : function (data) {
                    console.log(data)
                    swal({
                        title: 'Maaf...',
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