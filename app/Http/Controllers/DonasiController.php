<?php

namespace App\Http\Controllers;
use App\Pendanaan;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Projek;
use Session;

class DonasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id, $jenis)
    {
        $projek = Projek::where('id', $id)->where('kategori_id',$jenis)->first();
        // dd($projek);
        $pendanaan = Pendanaan::all();
        if($jenis==1){
            return view('front.projek.aset', ['projek' => $projek, 'pendanaan' => $pendanaan]);
        }else return view('front.projek.donasi', ['projek' => $projek, 'pendanaan' => $pendanaan]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nominal'       => 'required',
            'keterangan'    => 'required',
            'bukti'         => 'image|nullable',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
        $input = $request->all();
        $input['bukti'] = null;
        if ($request->hasFile('bukti')) {
            $input['bukti'] = '/upload/projek/' . str_slug($input['nama'], '-') . '.' . $request->bukti->getClientOriginalExtension();
            $request->bukti->move(public_path('/upload/donasi/'), $input['bukti']);
        }
        
        $pendanaan = Pendanaan::create([
            'nominal'       => $request->nominal,
            'metode'       => $request->metode ?? 'Penyerahan Aset',
            'unit'          => $request->unit, //id_jenis
            'tanggal'          => $request->tanggal,
            'bukti'         => $input['bukti' ],
            'keterangan'    => $request->keterangan,
            'user_id'       => Auth::user()->id,
            'projek_id'       => $request->projek_id,

        ]);
        $projek = Projek::findOrFail($request->projek_id);
        Session::flash('message', 'Terimakasih atas donasi Anda.');

        return redirect(route('projek.show', $projek->slug));
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
        //
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
