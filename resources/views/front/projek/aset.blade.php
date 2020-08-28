@extends('front.layouts.master')
@section('css')
<style>
    .box {
        max-height: 150px !important;
        display: flex;
        background-color: white;
        line-height: 1.25em;
        margin: 1em 0em;
    }

    .box-img {
        display: flex;
        -webkit-box-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        align-items: center;
        position: relative;
        z-index: 0;
        margin: 0px 20px 0px 0px;
        flex: 1 1 0%;
    }

    .box-desc {
        display: flex;
        flex-direction: column;
        -webkit-box-pack: justify;
        justify-content: space-between;
        flex: 1 1 0%;
        max-height: 150px !important;
    }

    .box-title {
        font-weight: 600;
        font-size: 12px;
        color: rgb(74, 74, 74);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        word-break: break-word;
        margin: 0.25em 0em;
        overflow: hidden;
    }

    .box-mitra {
        display: flex;
        width: 100%;
        vertical-align: middle;
        font-size: 10px;
        color: rgba(0, 0, 0, 0.8);
        -webkit-box-align: center;
        align-items: center;
        margin: 0.25em 0em;
    }

    .box-mitra span {
        white-space: nowrap;
        text-overflow: ellipsis;
        max-width: 110px;
        overflow: hidden;
    }

    .box-mitra img {
        height: 12px;
        margin-left: 0.25em;
    }

    img {
        max-width: 100%;
        vertical-align: middle;
        border-style: none;
        max-height: 150px !important;
    }

    .box-line-container {
        margin: 0.25em 0em;
    }

    .box-line {
        position: relative;
        width: 100%;
        height: 3px;
        background-color: rgba(0, 0, 0, 0.1);
        box-shadow: rgb(0, 0, 0) 0px 0px inset;
        border-radius: 10px;
    }

    .line {
        position: absolute;
        top: 0px;
        left: 0px;
        width: 100%;
        height: 100%;
        background-color: rgb(106, 210, 72);
        border-radius: 2px;
    }

    .box-dana-container {
        width: 100%;
        display: flex;
        -webkit-box-pack: justify;
        justify-content: space-between;
        margin: 0.25em 0em;
    }

    .box-dana-desc {
        display: flex;
        flex-direction: column;
    }

    .box-dana-desc span:nth-child(1) {
        font-weight: normal;
        font-size: 10px;
        color: rgb(74, 74, 74);
    }

    .box-dana-desc span:nth-child(2) {
        font-weight: bold;
        font-size: 12px;
    }

    .box-dana-date {
        display: flex;
        flex-direction: column;
    }

    .box-dana-date span:nth-child(1) {
        font-weight: normal;
        font-size: 10px;
        color: rgb(74, 74, 74);
    }

    .box-dana-date span:nth-child(2) {
        font-weight: bold;
        font-size: 12px;
        text-align: right;
    }
</style>
@endsection

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <h1>Donasi</h1>
        </div>
    </div>
</div>
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <form method="post" action="{{route('donasi.store')}}" enctype='multipart/form-data'>
                @csrf
                <input type="hidden" name="projek_id" id="projek_id" value="{{$projek->id}}">
                <div class="form-group">
                    <label id="name" for="nama">nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{Auth::user()->name}}" readonly>
                </div>
                <div class="form-group"><label for="unit" class="unit">Pilih Jenis</label>
                    <select name="unit" id="unit" class="form-control">
                        <option value="">-- Pilih --</option>
                        @foreach($projek->jenis as $item)
                        <option value="{{$item->jenis}}">{{$item->jenis}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label id="labelNominal" for="nominal">Unit</label>
                    <input type="text" class="@error('nominal') is-invalid @enderror form-control" id="nominal" placeholder="Masukkan Unit" name="nominal">
                    @error('nominal')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label id="tanggal" for="tanggal">Tanggal Penyerahan</label>
                    <input type="date" class="@error('tanggal') is-invalid @enderror form-control" id="tanggal" placeholder="Pilih Tanggal" name="tanggal">
                    @error('tanggal')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="bukti">Bukti Penyerahan</label>
                    <input type="file" class="@error('bukti') is-invalid @enderror form-control-file" id="bukti" name="bukti">
                    @error('bukti')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label id="keterangan" for="keterangan">Keterangan</label>
                    <input type="textarea" class="@error('keterangan') is-invalid @enderror form-control" id="keterangan" placeholder="Pilih keterangan" name="keterangan">
                    @error('keterangan')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary my-3">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
