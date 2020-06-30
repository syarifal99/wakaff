<?php

namespace App\Http\Controllers;

use App\Projek;
use App\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\User;

class ProjekController extends Controller
{
    public function index(){
        $projek = Projek::all();
        return view('project.index', ['projek' => $projek]);
    }
    public function create(){
        $provinsi = Provinsi::all();
        return view('front.projek.create', compact('provinsi'));
    }

    public function store(Request $request){
        // return $request;
        $this->validate($request, [
            'nama'          => 'required|unique:projek',
            'deskripsi'     => 'nullable',
            'tenggat_waktu' => 'required',
            'nominal'       => 'required',
            'image'        => 'image|nullable',
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
            'image'         => $request->image,
            'kategori_id'   => $request->kategori_id,
            'label_id'      => $request->label_id,
            'user_id'       => Auth::user()->id,
            'kota_id'       => $request->kota_id,
        ]);

        if($request->ajax()) return response()->json(['success' =>false, 'message' => 'Projek berhasil dibuat.']);
        return redirect(route('project.show', $projek->slug));
    }

    public function update(Request $request, $id){
        // return $request;
        $this->validate($request, [
            'nama'          => 'required|unique:projek,nama,' . $id . ',id',
            'deskripsi'     => 'nullable',
            'tenggat_waktu' => 'required',
            'nominal'       => 'required',
            'image'        => 'image|nullable',
            'kategori_id'   => 'required',
            'label_id'      => 'required',
            'kota_id'       => 'required',
        ]);

        $projek = Projek::findOrFail($id);
        
        $projek->update([
            'nama'          => $request->nama,
            'slug'          => $request->nama,
            'deskripsi'     => $request->deskripsi,
            'tenggat_waktu' => $request->tenggat_waktu,
            'nominal'       => $request->nominal,
            'image'         => $request->image,
            'kategori_id'   => $request->kategori_id,
            'label_id'      => $request->label_id,
            'kota_id'       => $request->kota_id,
            'mitra'         => $request->mitra,
            'status'        => $request->status,
        ]);

        if($request->ajax()) return response()->json(['success' =>false, 'message' => 'Projek berhasil diubah.']);
        return redirect(route('project.show', $projek->slug));
    }


    public function show($id){
        $mitra = User::whereHas('mitra_attr')->with('mitra_attr')->get();
        $projek = Projek::where('id', $id)
            ->with('user', 'mitra', 'kategori', 'label', 'kota.provinsi')
            ->firstOrFail();

        if(!$projek) return abort(404);

        $data = [
            'projek' => $projek,
            'mitra' => $mitra,
        ];
        return $data;
    }

    public function destroy($id)
    {
        $user = Projek::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'project deleted.',
        ]);
    }

    public function apiProject() {
		$projek = Projek::with(['kategori','label','kota.provinsi','user'])->get();

		return Datatables::of($projek)
            ->addColumn('action', function ($u) {
                return '<a  onclick="editForm('. $u->id .')" class="btn btn-info btn-icon-split btn-sm mr-2 mb-2"><span class="icon text-white-50"><i class="fas fa-edit"></i></span><span class="text text-white"> Edit</span></a>' .
                ' <a onclick="deleteData('. $u->id .')" class="btn btn-danger btn-icon-split btn-sm"><span class="icon text-white-50"><i class="fas fa-trash"></i></span><span class="text text-white"> Delete</span></a>';
            })
			->addColumn('show_image', function($s){
                if ($s->image == NULL){
                    return 'No Image';
                }
                return '<img class="rounded-square" width="50" height="50" src="'. url($s->image) .'" alt="">';
            })
			->rawColumns(['show_image','action'])->make(true);
	}
    
}
