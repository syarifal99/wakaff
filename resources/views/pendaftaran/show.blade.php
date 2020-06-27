@extends('layout.main')

@section('title', 'Detail Project')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h1 class="mt-3">Detail Data Project</h1>
                
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Nama Pendaftaran: {{ $pendaftaran->nm_pendaftaran }}</h5>
                    <p class="card-text">Nama Produk :  {{ $pendaftaran->nm_produk }}</p>
                    <p class="card-text">Kategori :     {{ $pendaftaran->kategori->kategori }}</p>
                    <p class="card-text">Label :   {{ $pendaftaran->label->label }}</p>
                    <p class="card-text">Nominal : {{ $pendaftaran->nominal }}</p>
                    <p class="card-text">Tenggat Waktu :    {{ $pendaftaran->tenggat_waktu }}</p>
                    <p class="card-text">Provinsi : {{ $pendaftaran->kota->provinsi->provinsi }}</p>
                    <p class="card-text">Kota : {{ $pendaftaran->kota->kota }}</p>
                    <p class="card-text">Status : {{ $pendaftaran->status }}</p>
                    <p class="card-text">Gambar :    {{ $pendaftaran->gambar }}</p>
                        
                    <a href="{{ $pendaftaran->id_pendaftaran }}/edit" class="btn btn-primary">Edit</a>    
                    
                    <form action="{{ $pendaftaran->id_pendaftaran }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                    <a href="/pendaftaran" class="card-link">Kembali</a>
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
