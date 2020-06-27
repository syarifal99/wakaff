<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Projek;
use App\Provinsi;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projek = Projek::with(['user','mitra'])->get();
        // return view('pendaftaran.index');
        return view('pendaftaran.index', ['projek' => $projek]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinsi = Provinsi::all();
        return view('front.projek.create', compact('provinsi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request;
        
        Projek::create($request->except('provinsi'));
        return redirect('/pendaftaran')->with('status','Data Project Berhasil Ditambahkan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pendaftaran = Projek::with(['kategori', 'label', 'kota.provinsi'])->findOrFail($id);
        // return $pendaftaran;
        return view('pendaftaran.show', compact('pendaftaran'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Projek $pendaftaran)
    {
        //$pendaftaran = Projek::with(['kategori', 'label', 'kota.provinsi'])->findOrFail($id);
        $provinsi = Provinsi::all();
        $kategori = Kategori::all();
        $label = Label::all();
        $kota = Kota::all();
        return view('pendaftaran.edit', compact('provinsi','kategori', 'label', 'kota', 'pendaftaran'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pendaftaran = Projek::with(['kategori', 'label', 'kota.provinsi'])->findOrFail($id);
        Projek::where('id_pendaftaran', $pendaftaran->id_pendaftaran)
            ->update([
                'nm_pendaftaran' => $request->nm_pendaftaran,
                'nm_produk' => $request->nm_produk,
                'id_kategori' => $request->id_kategori,
                'id_label' => $request->id_label,
                'nominal' => $request->nominal,
                'tenggat_waktu' => $request->tenggat_waktu,
                'id_kota' => $request->id_kota,
                'status' => $request->status,
                'gambar' => $request->gambar
            ]);
            return redirect('/pendaftaran')->with('status','Data Projek Project Berhasil Diubah !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Projek $pendaftaran)
    {
        Projek::destroy($pendaftaran->id_pendaftaran);
        return redirect('/pendaftaran')->with('status','Data Projek Berhasil Dihapus !');
    
    }
}
