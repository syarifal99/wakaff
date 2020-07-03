<?php

namespace App\Http\Controllers;
use App\Projek;
use App\Provinsi;
use DataTables;
use App\User;
use App\Kota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projek = Projek::all();
        return view('project.index', ['projek' => $projek]);
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
        $this->validate($request, [
            'nama'          => 'required|unique:projek',
            'deskripsi'     => 'nullable',
            'tenggat_waktu' => 'required',
            'nominal'       => 'required',
            'gambar'        => 'image|nullable',
            'kategori_id'   => 'required',
            'label_id'      => 'required',
            'kota_id'       => 'required',
        ]);

        $input = $request->all();
        $input['gambar'] = null;
        if ($request->hasFile('gambar')) {
            $input['gambar'] = '/upload/projek/' . str_slug($input['name'], '-') . '.' . $request->gambar->getClientOriginalExtension();
            $request->gambar->move(public_path('/upload/projek/'), $input['gambar']);
        }            
        $projek = Projek::create([
            'nama'          => $request->nama,
            'slug'          => $request->nama,
            'deskripsi'     => $request->deskripsi,
            'tenggat_waktu' => $request->tenggat_waktu,
            'nominal'       => $request->nominal,
            'gambar'         => $input['gambar'],
            'kategori_id'   => $request->kategori_id,
            'label_id'      => $request->label_id,
            'user_id'       => Auth::user()->id,
            'kota_id'       => $request->kota_id,
        ]);

        if($request->ajax()) return response()->json(['success' =>false, 'message' => 'Projek berhasil dibuat.']);
        return redirect(route('project.show', $projek->slug));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        $this->validate($request, [
            'nama'          => 'required|unique:projek,nama,' . $id . ',id',
            'deskripsi'     => 'nullable',
            'tenggat_waktu' => 'required',
            'nominal'       => 'required',
            'gambar'        => 'image|nullable',
            'kategori_id'   => 'required',
            'label_id'      => 'required',
            'kota_id'       => 'required',
        ]);

        $projek = Projek::findOrFail($id);

        $input = $request->all();
        $input['gambar'] = $projek->gambar;
        if ($request->hasFile('gambar')) {
            $input['gambar'] = '/upload/projek/' . str_slug($input['nama'], '-') . '.' . $request->gambar->getClientOriginalExtension();
            $request->gambar->move(public_path('/upload/projek/'), $input['gambar']);
        } else if($input['image_available']== false) {
			$input['gambar'] = NULL;
			try {unlink(public_path($projek->gambar));} catch (\Throwable $th) {}
		}
        $projek->update([
            'nama'          => $request->nama,
            'slug'          => $request->nama,
            'deskripsi'     => $request->deskripsi,
            'tenggat_waktu' => $request->tenggat_waktu,
            'nominal'       => $request->nominal,
            'gambar'        => $input['gambar'],
            'kategori_id'   => $request->kategori_id,
            'label_id'      => $request->label_id,
            'kota_id'       => $request->kota_id,
            'mitra_id'      => $request->mitra_id,
            'status'        => $request->status,
        ]);

        if($request->ajax()) return response()->json(['success' =>false, 'message' => 'Projek berhasil diubah.']);
        return redirect(route('project.show', $projek->slug));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Projek::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Projek deleted.',
        ]);
    }
    public function apiProject(){
        $user = Auth::user();
        $q = Projek::query();
        if(!$user->hasRole('superadmin')){
            $q->where('mitra_id', Auth::user()->id);
        }
        $q->with(['kategori','label','kota.provinsi','user', 'mitra']);
        $projek = $q->get();

		return Datatables::of($projek)
            ->addColumn('action', function ($u) {
                return '<a  onclick="editForm('. $u->id .')" class="btn btn-info btn-icon-split btn-sm mr-2 mb-2"><span class="icon text-white-50"><i class="fas fa-edit"></i></span><span class="text text-white"> Edit</span></a>' .
                ' <a onclick="deleteData('. $u->id .')" class="btn btn-danger btn-icon-split btn-sm"><span class="icon text-white-50"><i class="fas fa-trash"></i></span><span class="text text-white"> Delete</span></a>';
            })
			->addColumn('show_image', function($u){
                if ($u->gambar == NULL){
                    return 'No Image';
                }
                return '<img class="rounded-square" width="50" height="50" src="'. url($u->gambar) .'" alt="">';
            })
			->rawColumns(['show_image','action'])->make(true);
    }
}
