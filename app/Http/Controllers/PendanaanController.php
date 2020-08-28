<?php

namespace App\Http\Controllers;
use App\Pendanaan;
use App\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Projek;

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

    public function indexx()
    {
        return view('pendanaan.admin');
    }

    public function pendanaanaset()
    {
        return view('pendanaan.aset');
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
        $pendanaan = Pendanaan::where('id', $id)
            ->with('user', 'projek')
            ->firstOrFail();

        if(!$pendanaan) return abort(404);

        $data = [
            'projek' => $pendanaan->projek,
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
        $pendanaan = Pendanaan::where('id', $id)
            ->with('user', 'projek')
            ->firstOrFail();
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
        $user = User::with('mitra_attr')->findOrFail(Auth::user()->id);
		// $pendanaans = Pendanaan::whereHas('projek.mitra', function($q) use($user){
        //     if($user->mitra_attr) $q->where('id', $user->mitra_attr->id);
        // })->with('projek.mitra','user')->get();
        // return $pendanaans;
        $projeks = Projek::whereHas('mitra', function($q) use($user){
            if($user->mitra_attr) $q->where('id', $user->mitra_attr->id);
        })->where('kategori_id',2)->with(['mitra', 'user', 'pendanaan.user'])->get();
        $res = [];
        foreach ($projeks as $key => $p) {
            $totalDanaPendanaan = 0;
            foreach ($p->pendanaan as $key => $pd) {
                $totalDanaPendanaan += (float) $pd->nominal;
            }
            $res[] = [
                'projek' => $p,
                'total_user' => count($p->pendanaan),
                'total_pendanaan' => $totalDanaPendanaan,
            ];
        }
        // return $res;
		return Datatables::of($res)
			->addColumn('action', function ($p) {
                return
                '<button onclick="editForm(' . $p['projek']->id . ')" class="btn btn-success btn-circle btn-sm"><i class="fas fa-edit"></i></button>' .
                '<button onclick="deleteData(' . $p['projek']->id . ')" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></button>';
              })
            ->addColumn('show_image', function($p){
                if ($p['projek']->bukti == NULL){
                    return 'No Image';
                }
                return '<img class="rounded-square" width="50" height="50" src="'. url($p['projek']->bukti) .'" alt="">';
            })
			->rawColumns(['show_image','action'])->make(true);
    }

    public function apiPendanaanaset() {
        $user = User::with('mitra_attr')->findOrFail(Auth::user()->id);
		// $pendanaans = Pendanaan::whereHas('projek.mitra', function($q) use($user){
        //     if($user->mitra_attr) $q->where('id', $user->mitra_attr->id);
        // })->with('projek.mitra','user')->get();
        // return $pendanaans;
        $projeks = Projek::whereHas('mitra', function($q) use($user){
            if($user->mitra_attr) $q->where('id', $user->mitra_attr->id);
        })->where('kategori_id',1)->with(['mitra', 'user', 'pendanaan.user'])->get();
        $res = [];
        foreach ($projeks as $key => $p) {
            $totalDanaPendanaan = 0;
            foreach ($p->pendanaan as $key => $pd) {
                $totalDanaPendanaan += (float) $pd->nominal;
            }
            $res[] = [
                'projek' => $p,
                'total_user' => count($p->pendanaan),
                'total_pendanaan' => $totalDanaPendanaan,
            ];
        }
        // return $res;
		return Datatables::of($res)
			->addColumn('action', function ($p) {
                return
                '<button onclick="editForm(' . $p['projek']->id . ')" class="btn btn-success btn-circle btn-sm"><i class="fas fa-edit"></i></button>' .
                '<button onclick="deleteData(' . $p['projek']->id . ')" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></button>';
              })
            ->addColumn('show_image', function($p){
                if ($p['projek']->bukti == NULL){
                    return 'No Image';
                }
                return '<img class="rounded-square" width="50" height="50" src="'. url($p['projek']->bukti) .'" alt="">';
            })
			->rawColumns(['show_image','action'])->make(true);
    }

    function admintai(){
        $res = Pendanaan::with(['user', 'projek'])->whereHas('projek', function($asu) {
            return $asu->where('kategori_id', 2);
        })->get();

        return Datatables::of($res)
			->addColumn('action', function ($p) {
                return
                '<button onclick="editForm(' . $p->id . ')" class="btn btn-success btn-circle btn-sm"><i class="fas fa-edit"></i></button>' .
                '<button onclick="deleteData(' . $p->id . ')" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></button>';
              })
            ->addColumn('show_image', function($p){
                if ($p->bukti == NULL){
                    return 'No Image';
                }
                return '<img class="rounded-square" width="50" height="50" src="'. url($p->bukti) .'" alt="">';
            })
			->rawColumns(['show_image','action'])->make(true);
    }

    function adminsupertai(){
        $res = Pendanaan::with(['user', 'projek'])->whereHas('projek', function($asu) {
            return $asu->where('kategori_id', 1);
        })->get();

        return Datatables::of($res)
			->addColumn('action', function ($p) {
                return
                '<button onclick="editForm(' . $p->id . ')" class="btn btn-success btn-circle btn-sm"><i class="fas fa-edit"></i></button>' .
                '<button onclick="deleteData(' . $p->id . ')" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></button>';
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
