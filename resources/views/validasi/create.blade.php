@extends('layout.main')

@section('title', 'Form Pemilihan validasi Mitra')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h1 class="mt-3">Form Pemilihan Validasi Mitra</h1>
        
            <form method="post" action="/validasi">
            @csrf
            <div class="form-group">
                <label for="Pendaftaran">Pendaftaran</label>
                <select class="form-control" id="Pendaftaran" placeholder="Masukkan Pendaftaran" name="id_pendaftaran">
                    <option value="">--Pilih Project--</option>
                    @foreach($pendaftaran as $v)
                    <option value="{{$v->id_pendaftaran}}">{{$v->nm_pendaftaran}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="Mitra">Mitra</label>
                <select class="form-control" id="Mitra" placeholder="Masukkan Mitra" name="id_mitra">
                    <option value="">--Pilih Mitra--</option>
                    @foreach($mitra as $m)
                    <option value="{{$m->id_mitra}}">{{$m->nm_mitra}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary my-3">Tambah Data</button>   
            </form>

        </div>
    </div>
</div>
@endsection
