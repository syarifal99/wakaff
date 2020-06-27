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
            <h1>Buat Projek</h1>
        </div>
    </div>
</div>
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <form method="post" action="{{route('projek.store')}}">
                @csrf
                <div class="form-group">
                    <label for="nama">Judul/Nama</label>
                    <input type="text" class="@error('nama') is-invalid @enderror form-control" id="nama" placeholder="Contoh: Zakat untuk kaum dhuafa"
                        name="nama">
                    @error('nama')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="kategori_id">Kategori</label>
                    <select class="form-control" id="kategori_id" placeholder="Pilih kategori" name="kategori_id">
                        <option value="" disabled>-- Pilih kategori --</option>
                        <option value="1">Wakaf Aset</option>
                        <option value="2">Wakaf Tunai</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="label_id">Label</label>
                    <select class="form-control" id="label_id" placeholder="Pilih label" name="label_id">
                        <option value="" disabled>-- Pilih label --</option>
                        <option value="1">Produktif</option>
                        <option value="2">Non Produktif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label id="labelNominal" for="nominal">Nominal</label>
                    <input type="text" class="@error('nominal') is-invalid @enderror form-control" id="nominal" placeholder="Pilih nominal" name="nominal">
                    @error('nominal')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="tenggat_waktu Waktu">Tenggat Waktu</label>
                    <input type="date" class="@error('nominal') is-invalid @enderror form-control" id="tenggat_waktu" name="tenggat_waktu">
                    @error('tenggat_waktu')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="provinsi_id">Provinsi</label>
                    <select class="form-control" id="provinsi_id" name="provinsi_id">
                        <option value="">-- Pilih provinsi --</option>
                        @foreach ($provinsi as $p)
                        <option value="{{$p->id}}">{{$p->provinsi}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="kota">Kota</label>
                    <select class="form-control" id="kota_id" placeholder="Pilih kota" name="kota_id">
                        <option value="" disabled>-- Pilih Kota --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="gambar">Gambar</label>
                    <input type="file" class="@error('nominal') is-invalid @enderror form-control-file" id="gambar" name="gambar">
                    @error('gambar')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary my-3">Submit</button>
            </form>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="box">
                <figure class="box-img"><img alt="Rumah Yatim"
                        src="https://kitabisa-userupload-01.s3-ap-southeast-1.amazonaws.com/_production/campaign/36696/31_36696_1505353544_778910_f.png"
                        class="cTDNTQ">
                </figure>
                <div class="box-desc"><span class="box-title">Rumah Yatim</span>
                    <div class="box-mitra"><span>Rumah Yatim</span>
                        <img src="https://assets.kitabisa.cc/images/icons/icon__verified-org.svg" alt="icon__badge">
                    </div>
                    <div class="box-line-container">
                        <div class="box-line">
                            <div color="green" class="line"></div>
                        </div>
                    </div>
                    <div class="box-dana-container">
                        <div type="donationCollected" class="box-dana-desc">
                            <span>Terkumpul</span><span>Rp 13.212.289.390</span></div>
                        <div type="dayLeft" class="box-dana-date"><span>Sisa
                                hari</span><span>12</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function(){
        $(document).on("change", "#kategori_id", function() {
            if ($(this).val()==1){    
                $('#nominal').attr('placeholder', 'Masukkan unit');
                $('#labelNominal').text('Unit');
            }else {
                $('#nominal').attr('placeholder', 'Masukkan nominal');
                $('#labelNominal').text('Nominal');
            }        
        })
        $(document).on("change", "#provinsi_id", function() {
            let id = $(this).val()
            if(!id) return false;
            $.ajax({
                url : "{{ url('provinsi') . '/' }}" + id,
                type : "GET",
                success: function(res){
                    console.log(res)
                    $("#kota_id").empty();
                    $("#kota_id").append(`<option value="" selected disabled>-- Pilih kota --</option>`);
                    $.each(res.kota, function(key, item) {
                        $("#kota_id").append(`<option value="` + item.id + `">` + item.kota +` </option>`);
                    });
                }, error: function(error){
                    console.log(error);
                }
            });
        });
    }) 
</script>
@endsection