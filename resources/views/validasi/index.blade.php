@extends('layout.main')

@section('title', 'Validasi')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h1 class="mt-3">Pemilihan Validasi Mitra</h1>
                
                <a href="/validasi/create" class="btn btn-primary my-3">Tambah Data</a>
                
                @if (session('status'))
                    <div class = "alert alert-succes">
                {{ session('status') }}
                    </div>
                @endif
                <ul class="list-group">
                    @foreach ($validasi as $v)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $v-> id_validasi}}
                    <a href="/validasi/{{$v->id_validasi}}" class="badge badge-info">detail</a>
                    </li>
                    @endforeach
                </ul>
        </div>
    </div>
</div>
@endsection
