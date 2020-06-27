<?php

namespace App\Http\Controllers;

use App\Projek;
use App\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjekController extends Controller
{
    public function index(){
        $projek = Projek::all();
        return view('front.projek.index', ['projek' => $projek]);
    }

    public function create(){
        $provinsi = Provinsi::all();
        return view('front.projek.create', compact('provinsi'));
    }

    public function store(Request $request){
        // return $request;
        $this->validate($request, [
            'nama'          => 'required|unique:projek',
            'deskripsi'     => 'required',
            'tenggat_waktu' => 'required',
            'nominal'       => 'required',
            'gambar'        => 'image|nullable',
            'kategori_id'   => 'required',
            'label_id'      => 'required',
            'kota_id'       => 'required',
        ]);

        $projek = Projek::create([
            'nama'          => $request->nama,
            'slug'          => $request->nama,
            'deskripsi'     => $request->deskripsi,
            'tenggat_waktu' => $request->tenggat_waktu,
            'nominal'       => $request->nominal,
            'gambar'        => $request->gambar,
            'kategori_id'   => $request->kategori_id,
            'label_id'      => $request->label_id,
            'user_id'       => Auth::user()->id,
            'kota_id'       => $request->kota_id,
        ]);

        return redirect(route('projek.show', $projek->slug));
    }

    public function show($slug){
        $projek = Projek::where('slug', $slug)
            ->with('user', 'mitra')
            ->firstOrFail();

        if(!$projek) return abort(404);

        return view('front.projek.show', [
            'projek' => $projek
        ]);
    }

    
}
