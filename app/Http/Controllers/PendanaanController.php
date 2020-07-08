<?php

namespace App\Http\Controllers;
use App\Pendanaan;
use App\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class PendanaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pendanaan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pendanaan = User::whereHas('mitra_attr')->with('mitra_attr')->get();
        $projek = Projek::where('id', $id)
            ->with('user', 'projek')
            ->firstOrFail();

        if(!$projek) return abort(404);

        $data = [
            'projek' => $projek,
            'mitra' => $pendanaan,
        ];
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pendanaan = Pendanaan::find($id);
		return $pendanaan;
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
        $this->validate($request, [
			'nominal' 	=> 'required|max:191',
			'metode' 	=> 'required|max:191',
			'keterangan' 	=> 'required',

		]);
		$pendanaan = Pendanaan::findOrFail($id);
		$input = $request->all();
		$pendanaan->update([
			'name'         => $request->name,
			'nominal'         => $request->nominal,
			'metode'         => $request->metode,
            'keterangan'     	=> $request->keterangan,
            'status'        => $request->status,
		]);

		if($request->ajax()) return response()->json(['success' =>false, 'message' => 'pendanaan berhasil diubah.']);
        return redirect(route('pendanaan.show', $pendanaan->id));
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
    public function apiPendanaan() {
		$pendanaans = Pendanaan::with('projek.mitra','user')->get();

		return Datatables::of($pendanaans)
			->addColumn('action', function ($p) {
                return '<a  onclick="editForm('. $p->id .')" class="btn btn-info btn-icon-split btn-sm mr-2 mb-2"><span class="icon text-white-50"><i class="fas fa-edit"></i></span><span class="text text-white"> Edit</span></a>' .
                ' <a onclick="deleteData('. $p->id .')" class="btn btn-danger btn-icon-split btn-sm"><span class="icon text-white-50"><i class="fas fa-trash"></i></span><span class="text text-white"> Delete</span></a>';
            })
            ->addColumn('show_image', function($p){
                if ($p->bukti == NULL){
                    return 'No Image';
                }
                return '<img class="rounded-square" width="50" height="50" src="'. url($p->bukti) .'" alt="">';
            })
			->rawColumns(['show_image','action'])->make(true);
	}
}
