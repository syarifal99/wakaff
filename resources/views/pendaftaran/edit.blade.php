@extends('layout.main')

@section('title', 'Form Ubah Project')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h1 class="mt-3">Form Ubah Project</h1>
        
            <form method="post" action="/pendaftaran/{{ $pendaftaran->id_pendaftaran }}">
            @method('patch')
            @csrf
            <div class="form-group">
                <label for="Nama_Pendaftaran">Nama Pendaftaran</label>
                <input type="text" class="form-control" id=Nama_Pendaftaran" placeholder="Masukkan Nama Pendaftaran" name="nm_pendaftaran" value="{{ $pendaftaran->nm_pendaftaran }}">
            </div>
            <div class="form-group">
                <label for="Nama_Produk">Nama Produk</label>
                <input type="text" class="form-control" id="Nama_Produk" placeholder="Masukkan Nama Produk" name="nm_produk" value="{{ $pendaftaran->nm_produk }}">
            </div>
            <div class="form-group">
                <label for="Kategori">Kategori</label>
                <select  class="form-control" id="Kategori" placeholder="Masukkan Kategori" name="id_kategori">
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id_kategori}}"
                        @if ($k->id_kategori === $pendaftaran->id_kategori)
                            selected
                        @endif
                        >
                        {{ $k->kategori }} </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="Label">Label</label>
                <select class="form-control" id="Label" placeholder="Masukkan Label" name="id_label" value="{{ $pendaftaran->label }}">
                    @foreach ($label as $l)
                        <option value="{{ $l->id_label}}"
                        @if ($l->id_label === $pendaftaran->id_label)
                            selected
                        @endif
                        >
                        {{ $l->label }} </option>
                    @endforeach
                </select>
            </div> 
            <div class="form-group">
                <label id="labelNominal" for="Nominal">Nominal</label>
                <input type="text" class="form-control" id="Nominal" placeholder="Masukkan Nominal" name="nominal" value="{{ $pendaftaran->nominal }}">
            </div>
            <div class="form-group">
                <label for="Tenggat_Waktu">Tenggat Waktu</label>
                <input type="date" class="form-control" id="Tenggat_Waktu" name="tenggat_waktu" value="{{ $pendaftaran->tenggat_waktu}}">
            </div>
            <div class="form-group">
                <label for="Kota">Kota</label>
                <select class="form-control" id="Kota" placeholder="Masukkan Kota" name="id_kota" value="{{ $pendaftaran->kota->kota }}">
                    @foreach ($kota as $kl)
                        <option value="{{ $kl->id_kota}}"
                        @if ($kl->id_kota === $pendaftaran->id_kota)
                            selected
                        @endif
                        >
                        {{ $kl->kota }} </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="Staus">Status</label>
                <select  class="form-control" id="Status" placeholder="Masukkan Status" name="status" value="{{ $pendaftaran->status}}">
                    <option value="">-- Menunggu --</option>
                    <option value="Belum Disetujui">Belum Disetujui</option>
                    <option value="Disetujui">Disetujui</option>
                </select>
            </div>
            <div class="form-group">
                <label for="Gambar">Gambar</label>
                <input type="file" class="form-control-file" id="Gambar" name="gambar" value="{{ $pendaftaran->gambar }}">
            </div>
            <button type="submit" class="btn btn-primary my-3">Ubah Data</button>   
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