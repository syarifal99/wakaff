@extends('layout.main')

@section('title', 'Form Tambah Project')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h1 class="mt-3">Form Tambah Project</h1>
        
            <form method="post" action="/pendaftaran">
            @csrf
            <div class="form-group">
                <label for="Nama Pendaftaran">Nama Pendaftaran</label>
                <input type="text" class="form-control" id="nm_pendaftaran" placeholder="Masukkan Nama Pendaftaran" name="nm_pendaftaran">
            </div>
            <div class="form-group">
                <label for="Nama Produk">Nama Produk</label>
                <input type="text" class="form-control" id="nm_produk" placeholder="Masukkan Nama Produk" name="nm_produk">
            </div>
            <div class="form-group">
                <label for="Kategori">Kategori</label>
                <select  class="form-control" id="Kategori" placeholder="Masukkan Kategori" name="id_kategori">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="1">Wakaf Aset</option>
                    <option value="2">Wakaf Tunai</option>
                </select>
            </div>
            <div class="form-group">
                <label for="Label">Label</label>
                <select class="form-control" id="Label" placeholder="Masukkan Label" name="id_label">
                    <option value="">-- Pilih Label --</option>
                    <option value="1">Produktif</option>
                    <option value="2">Non Produktif</option>
                </select>
            </div> 
            <div class="form-group">
                <label id="labelNominal" for="Nominal">Nominal</label>
                <input type="text" class="form-control" id="Nominal" placeholder="Masukkan Nominal" name="nominal">
            </div>
            <div class="form-group">
                <label for="Tenggat Waktu">Tenggat Waktu</label>
                <input type="date" class="form-control" id="tenggat_waktu" name="tenggat_waktu">
            </div>
            <div class="form-group">
                <label for="Provinsi">Provinsi</label>
                <select class="form-control" id="Provinsi" name="provinsi">
                <option value="">-- Pilih Provinsi --</option>
                @foreach ($provinsi as $p)
                <option value="{{$p->id_provinsi}}">{{$p->provinsi}}</option>
                @endforeach 
                </select>
            </div>
            <div class="form-group">
                <label for="Kota">Kota</label>
                <select class="form-control" id="Kota" placeholder="Masukkan Kota" name="id_kota">
                <option disabled value="">== Pilih Kota ==</option>
                </select>
            </div>
            <div class="form-group">
                <label for="Gambar">Gambar</label>
                <input type="file" class="form-control-file" id="gambar" name="gambar">
            </div>
            <button type="submit" class="btn btn-primary my-3">Tambah Data</button>   
            </form>

        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function(){
    $(document).on("change", "#Kategori", function() {
        if ($(this).val()==1){    
        $('#Nominal').attr('placeholder', 'masukkan unit');
        $('#labelNominal').text('Unit');
        }else {
        $('#Nominal').attr('placeholder', 'masukkan nominal');
        $('#labelNominal').text('Nominal');
        }        
    })
    $(document).on("change", "#Provinsi", function() {
         $.ajax({
            url : "{{route('kota.show')}}",
            type : "GET",
            data : {
               id_provinsi:$(this).val(),
            },
            success: function(html){
               console.log(html);
               $("#Kota").empty();
               $("#Kota").append(`<option value="" selected disabled>-- Pilih Kota --</option>`);
               $.each(html, function(key, item) {
                  $("#Kota").append(`<option value="` + item.id_kota + `">` + item.kota +` </option>`);
               });
            }, error: function(error){
                console.log(error);
                
            }
         });
      });
}) 
</script>
@endsection