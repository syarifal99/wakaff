<?php

namespace App\Http\Controllers;

use App\Projek;
use App\Provinsi;
use App\Pendanaan;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class ProjekController extends Controller
{
    public function index(){
        $projek = Projek::where('status', 'DISETUJUI')->get();
        return view('front.projek.index', ['projek' => $projek]);
    }

    public function create(){
        $provinsi = Provinsi::all();
        return view('front.projek.create', compact('provinsi'));
    }

    public function store(Request $request){
        // return $request;
        $validator = Validator::make($request->all(), [
            'nama'          => 'required|unique:projek',
            'tenggat_waktu' => 'required',
            'nominal'       => 'required',
            'gambar'        => 'image|nullable',
            'kategori_id'   => 'required',
            'label_id'      => 'required',
            'kota_id'       => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
        $input = $request->all();
        $input['gambar'] = null;
        if ($request->hasFile('gambar')) {
            $input['gambar'] = '/upload/donasi/' . str_slug($input['nama'], '-') . '.' . $request->gambar->getClientOriginalExtension();
            $request->gambar->move(public_path('/upload/donasi/'), $input['gambar']);
        }

        $projek = Projek::create([
            'nama'          => $request->nama,
            'slug'          => $request->nama,
            'deskripsi'     => $request->deskripsi,
            'tenggat_waktu' => $request->tenggat_waktu,
            'nominal'       => $request->nominal,
            'gambar'        => $input['gambar'],
            'kategori_id'   => $request->kategori_id,
            'label_id'      => $request->label_id,
            'user_id'       => Auth::user()->id,
            'kota_id'       => $request->kota_id,
        ]);

        return redirect(route('projek.show', $projek->slug));
    }

    public function show($slug){
        $projek = Projek::where('slug', $slug)
            ->with('user', 'mitra', 'pendanaan')
            ->firstOrFail();
        $q = Pendanaan::query();
        $q->where('projek_id', $projek->id);
        $q->select(DB::raw('sum(nominal) as total'));
        $pendanaan = $q->get();
        $pendanaan_count = $q->count();

        if(!$projek) return abort(404);
        return view('front.projek.show', [
            'projek' => $projek,
            'pendanaan' => $pendanaan[0],
            'pendanaan_count' => $pendanaan_count,
        ]);
    }


}
