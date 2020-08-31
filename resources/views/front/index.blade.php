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
<div class="position-relative overflow-hidden p-3 text-center bg-light">
    <div class="col-md-5 mx-auto my-5">
        <h1 class="font-weight-normal">Sistem Wakaf</h1>
        <p class="lead">Wakaf adalah sedekah jariyah, yakni menyedekahkan harta kita untuk kepentingan ummat. Harta Wakaf tidak boleh berkurang
        nilainya, tidak boleh dijual dan tidak boleh diwariskan</p>
        <a class="btn btn-outline-secondary" href="{{route('projek.create')}}">Galang Dana</a>
    </div>
    <div class="product-device shadow-sm d-none d-md-block"></div>
    <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
</div>


@endsection