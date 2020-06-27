@extends('layouts.master')
@section('title')
Roles & Permissions
@endsection
@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('content')
<!-- Page Heading -->
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h5>Roles & Permission Management</h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li> / </li>
                            <li class="active"> Roles & Permission</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings (Monthly)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Earnings (Annual)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks</div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Requests</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
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
                    <h4>Roles & Permission Management</h4>
                </div> --}}
                <div class="card-body">
                    <div class="default-tab">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-roles-tab" data-toggle="tab"
                                    href="#nav-roles" role="tab" aria-controls="nav-roles"
                                    aria-selected="true">Roles</a>
                                <a class="nav-item nav-link" id="nav-permissions-tab" data-toggle="tab"
                                    href="#nav-permissions" role="tab" aria-controls="nav-permissions"
                                    aria-selected="false">Permissions</a>
                            </div>
                        </nav>
                        <div class="tab-content pl-3 pt-4" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-roles" role="tabpanel"
                                aria-labelledby="nav-roles-tab">
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="btn-group btn-group-md">
                                        <button onclick="addRole()" class="btn btn-success">Tambahkan role</button>
                                    </div>
                                    <div class="btn-group btn-group-md">
                                        <button type="button" class="btn btn-outline-success btn-sm"
                                            id="btn-refreshrole" title="Refresh data"><i
                                                class="fas fa-sync-alt"></i></button>
                                    </div>
                                </div>
                                <table id="roles-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama</th>
                                            <th>Jumlah User</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="nav-permissions" role="tabpanel"
                                aria-labelledby="nav-permissions-tab">
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="btn-group btn-group-md">
                                        <button onclick="addPermission()" class="btn btn-success">Tambahkan
                                            permission</button>
                                    </div>
                                    <div class="btn-group btn-group-md">
                                        <button type="button" class="btn btn-outline-success btn-sm"
                                            id="btn-refreshpermission" title="Refresh data"><i
                                                class="fas fa-sync-alt"></i></button>
                                    </div>
                                </div>
                                <table id="permissions-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-role" tabindex="-1" role="dialog" aria-labelledby="modal-roleLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="form-role" method="post" class="form-horizontal" data-toggle="validator"
                    enctype="multipart/form-data" autocomplete="off">
                    {{ csrf_field() }} {{ method_field('POST') }}
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-roleLabel">Scrolling Long Content Modal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="root">
                        <input type="hidden" id="id" name="id">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" id="name" name="name" autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group">
                            <label>Permissions</label>
                            <div class="row permissions"></div>
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

    <div class="modal fade" id="modal-permission" tabindex="-1" role="dialog" aria-labelledby="modal-permissionLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="form-permission" method="post" class="form-horizontal" data-toggle="validator"
                    enctype="multipart/form-data" autocomplete="off">
                    {{ csrf_field() }} {{ method_field('POST') }}
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-permissionLabel">Scrolling Long Content Modal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="root">
                        <input type="hidden" id="id" name="id">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" id="name" name="name" autofocus required>
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
        $('#btn-refreshrole').on('click', function(){
            $('#roles-table').DataTable().draw(true)
        })
        $('#btn-refreshpermission').on('click', function(){
            $('#permissions-table').DataTable().draw(true)
        })
        var rolesTable = $('#roles-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('api.roles') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {
                    data: null, orderable: false, width: '100px',
                    render: function (data) {
                        return `<span class="badge badge-success">${data.users_count} users</span>`
                    }
                },
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        $('#modal-role form').validator().on('submit', function (e) {
            if (!e.isDefaultPrevented()){
                var id = $('#form-role #id').val();
                if (save_method == 'add') url = "{{ url('dashboard/roles') }}";
                    else url = "{{ url('dashboard/roles') . '/' }}" + id;

                $.ajax({
                    url : url,
                    type : "POST",
                    //hanya untuk input data tanpa dokumen
//                      data : $('#modal-role form').serialize(),
                    data: new FormData($("#modal-role form")[0]),
                    contentType: false,
                    processData: false,
                    success : function(data) {
                        console.log(data)
                        $('#modal-role').modal('hide');
                        rolesTable.ajax.reload();
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
                            title: 'Oops...',
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
    
    function initPermissions(){
        $.ajax({
            url: "{{ url('permissions') }}",
            type: "GET",
            async: false,
            dataType: "JSON",
            success: function(permissions) {
                let str = ''
                $.each(permissions, (k,v)=>{
                    str += `<div class="col-md-6 col-12">
                                <div class="checkbox checkbox-solid-primary">
                                    <input id="`+ v.name +`" type="checkbox" class="cb_permission" value="`+ v.name +`" name="permission_name[]">
                                    <label for="`+ v.name +`">`+ v.name +`</label>
                                </div>
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
    
    function addRole() {
        initPermissions()
        save_method = "add";
        $('#form-role input[name=_method]').val('POST');
        $('#modal-role').modal('show');
        $('#modal-role form')[0].reset();
        $('.modal-title').text('Tambah Role');
    }

    function editRole(id) {
        initPermissions()
        save_method = 'edit';
        $('#form-role input[name=_method]').val('PATCH');
        $('#modal-role form')[0].reset();
        $.ajax({
            url: "{{ url('dashboard/roles') }}" + '/' + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                console.log(data)
                let checkboxes = $('.cb_permission')
                let permissions = data.permissions
                $.each(checkboxes, (k,v)=>{
                    permissions.forEach(p => {
                        if(v.value == p.name) v.checked = true
                    });
                })
                
                $('#modal-role').modal('show');
                $('.modal-title').text('Edit Role');

                $('#form-role #id').val(data.id);
                $('#form-role #name').val(data.name);
            },
            error : function(err) {
                console.log(err)
                alert("Data not found!");
            }
        });
    }

    function deleteRole(id){
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
                url : "{{ url('dashboard/roles') }}" + '/' + id,
                type : "POST",
                data : {'_method' : 'DELETE', '_token' : csrf_token},
                success : function(data) {
                    $('#roles-table').DataTable().draw(true);
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
    // Roles End
    // Permissions Start
    $(document).ready(function() {
        var permissionsTable = $('#permissions-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('api.permissions') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        $('#modal-permission form').validator().on('submit', function (e) {
            if (!e.isDefaultPrevented()){
                var id = $('#form-permission #id').val();
                if (save_method == 'add') url = "{{ url('permissions') }}";
                else url = "{{ url('permissions') . '/' }}" + id;

                $.ajax({
                    url : url,
                    type : "POST",
                    //hanya untuk input data tanpa dokumen
//                      data : $('#modal-permission form').serialize(),
                    data: new FormData($("#modal-permission form")[0]),
                    contentType: false,
                    processData: false,
                    success : function(data) {
                        console.log(data)
                        $('#modal-permission').modal('hide');
                        permissionsTable.ajax.reload();
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
                            title: 'Oops...',
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
    
    function addPermission() {
        save_method = "add";
        $('#form-permission input[name=_method]').val('POST');
        $('#modal-permission').modal('show');
        $('#modal-permission form')[0].reset();
        $('.modal-title').text('Tambah Permission');
    }

    function editPermission(id) {
        save_method = 'edit';
        $('#form-permission input[name=_method]').val('PATCH');
        $('#modal-permission form')[0].reset();
        $.ajax({
            url: "{{ url('permissions') }}" + '/' + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                console.log(data)
                $('#modal-permission').modal('show');
                $('.modal-title').text('Edit Permission');

                $('#form-permission #id').val(data.id);
                $('#form-permission #name').val(data.name);
            },
            error : function(err) {
                console.log(err)
                alert("Data not found!");
            }
        });
    }

    function deletePermission(id){
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
                url : "{{ url('permissions') }}" + '/' + id,
                type : "POST",
                data : {'_method' : 'DELETE', '_token' : csrf_token},
                success : function(data) {
                    $('#permissions-table').DataTable().draw(true);
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
    // Permissions End
</script>
@endsection