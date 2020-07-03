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
        <div class="col-10">
            <div class="card">
                {{-- <img class="card-img-top" alt="{{$projek->nama}}" src="{{asset('uploads/projek/'.$projek->gambar)}}"> --}}
                <img class="card-img-top" alt="{{$projek->nama}}" src="{{$projek->gambar}}">
                <div class="card-body">
                    <h5 class="card-title" style="font-weight: bold;">{{$projek->nama}}</h5>
                    <p class="card-text">{{$projek->deskripsi}}</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><span>{{isset($projek->mitra)?$projek->user->name: '-'}}</span><img
                            src="https://assets.kitabisa.cc/images/icons/icon__verified-org.svg" alt="icon__badge"></li>
                    <li class="list-group-item">
                        <div class="box-line-container">
                            <span style="font-size: 15px;">{{$pendanaan_count}} donasi</span>
                            <div class="box-line">
                                <div color="green" class="line"></div>
                            </div>
                        </div>
                        <div class="box-dana-container">
                            <div type="donationCollected" class="box-dana-desc">
                                <span style="font-size: 18px;">Rp {{$pendanaan->total}}</span></div>
                            <div type="dayLeft" class="box-dana-date">
                                <span style="font-size: 15px; font-weight: bold;">{{date('j M Y', strtotime($projek->tenggat_waktu))}}</span>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="card-body">
                    <a href="{{route('donasi.create', $projek->id)}}" class="btn btn-secondary">Donasi sekarang</a>
                </div>
            </div>
        </div>
    </div>
    @if (Session::get('message'))
        <div class="row">
            <div class="col-12">
                <p>{{Session::get('message')}}</p>
            </div>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-12">
            <h2>Kabar Terbaru</h2>
            <p class="text-justify">Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis distinctio saepe illo aperiam reprehenderit rerum vel magnam architecto ut, obcaecati quas cupiditate doloremque dolores dolor aspernatur laborum accusantium modi quo.</p>
        </div>
        <div class="col-12">
            <h5 class="font-weight-bold">Kabar Terbaru</h5>
            <div class="row">
                <div class="col-12">
                    <img class="img-fluid" alt="{{$projek->nama}}" src="https://kitabisa-userupload-01.s3-ap-southeast-1.amazonaws.com/_production/campaign/36696/31_36696_1505353544_778910_f.png">
                </div>
            </div>
            <p class="text-justify">Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis distinctio saepe illo aperiam reprehenderit rerum vel magnam architecto ut, obcaecati quas cupiditate doloremque dolores dolor aspernatur laborum accusantium modi quo.</p>
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