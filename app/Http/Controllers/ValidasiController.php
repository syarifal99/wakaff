<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Validasi;
use App\Pendaftaran;
use App\Mitra;
use App\Projek;

class ValidasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $validasi = DB::table('validasi')->get();
        return view('validasi.index', ['validasi' => $validasi]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pendaftaran = Pendaftaran::all();
        $mitra = Mitra::all();
        return view('validasi.create', compact('pendaftaran', 'mitra'));
    }

    public function validasi(Request $request, $id)
    {
        $projek = Projek::where('id', $id)
            ->firstOrFail();

        $projek->update([
            'status'    => $request->status
        ]);
        
        return response()->json(['success' =>false, 'message' => 'Projek disetujui.']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validasi::create($request->all());
        return redirect('/validasi')->with('status','Pemilihan Validasi Mitra Berhasil Ditambahkan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mitra = User::whereHas('mitra_attr')->get();
        $projek = Projek::where('slug', $slug)
            ->with('user', 'mitra')
            ->firstOrFail();

        if(!$projek) return abort(404);

        $data = [
            'mitra' => $mitra,
            'project'   => $projek,
            'success' =>false, 
            'message' => 'Projek disetujui.'
        ];
        
        return $data;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
