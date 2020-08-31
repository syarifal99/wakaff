<?php

namespace App\Http\Controllers;
use App\Projek;
use App\Provinsi;
use DataTables;
use App\User;
use App\Kota;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Jenis;

class ProjectController extends Controller
{
    public function getAll(){
        $user = User::with('mitra_attr')->findOrFail(Auth::user()->id);

        $query = Projek::query();
        if( $user->hasRole(['mitra']) ){
            $query->where('mitra_id', $user->mitra_attr->id);
        }
        $projek = $query->get();
        return  $projek;
	}
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
            $input['gambar'] = '/upload/projek/' . str_slug($input['nama'], '-') . '.' . $request->gambar->getClientOriginalExtension();
            $request->gambar->move(public_path('/upload/projek/'), $input['gambar']);
        }            
        if($request->jenis != '') {
            foreach ($request->jenis as $value) {
                Jenis::firstOrCreate([
                    'jenis' => $value
                ], [
                    'jenis' => $value
                ]);
            }
            $id_jenis = [];
            foreach ($request->jenis as $value) {
                $id_jenis[] = Jenis::where('jenis', $value)->first()->id;
            }
        }

        
        $projek = Projek::create([
            'nama'          => $request->nama,
            'slug'          => \Str::slug($request->nama),
            'deskripsi'     => $request->deskripsi,
            'tenggat_waktu' => $request->tenggat_waktu,
            'nominal'       => $request->nominal,
            'gambar'        => $input['gambar'],
            'kategori_id'   => $request->kategori_id,
            'label_id'      => $request->label_id,
            'user_id'       => Auth::user()->id,
            'kota_id'       => $request->kota_id,
            'jenis'         => $request->jenis,
            'status'        => isset($request->status)?$request->status:'MENUNGGU',
        ]);

        if($request->jenis != '') $projek->jenis()->attach($id_jenis);
        
        $_user = Auth::user();
        if( $_user->hasRole(['mitra']) ){
            $user = User::with('mitra_attr')->findOrFail($_user->id);
            $projek->update(['mitra_id' => $user->mitra_attr->id,]);
        }

        if($request->ajax()) return response()->json(['success' =>true, 'message' => 'Projek berhasil dibuat.']);
        return redirect(route('project.index', $projek));
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
            ->with('user', 'jenis', 'mitra', 'kategori', 'label', 'kota.provinsi')
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
        if($request->jenis != '') {
            foreach ($request->jenis as $value) {
                Jenis::firstOrCreate([
                    'jenis' => $value
                ], [
                    'jenis' => $value
                ]);
            }
            $id_jenis = [];
            foreach ($request->jenis as $value) {
                $id_jenis[] = Jenis::where('jenis', $value)->first()->id;
            }
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
            'mitra_id'      => isset($request->mitra_id)?$request->mitra_id:$projek->mitra_id,
        ]);

        if($request->jenis != '') $projek->jenis()->attach($id_jenis);

        $_user = Auth::user();
        if( $_user->hasRole(['admin']) ){
            $projek->update(['status' => isset($request->status)?$request->status: $projek->status]);
        }
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
    public function apiProject(Request $request){
        $user = User::with('mitra_attr')->findOrFail(Auth::user()->id);
        $query = Projek::query();

        if( !$user->hasRole(['superadmin', 'admin']) ){
            $query->where('mitra_id', $user->mitra_attr->id);
        }
        $query->with(['kategori','label','kota.provinsi','user', 'mitra']);
        $query->when($request->q, function($query) use($request) {
            $query->where('kategori_id', $request->q);
        });
        $projek = $query->get();

		return Datatables::of($projek)
            ->addColumn('action', function ($u) {
                return 
                '<button onclick="editForm(' . $u->id . ')" class="btn btn-primary btn-circle btn-sm"><i class="fas fa-edit"></i></button>' .
                '<button onclick="deleteData(' . $u->id . ')" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></button>'.
                ' <a target="_blank" href="'. route('project.export.pdf', $u->id) .'" class="btn btn-success btn-circle btn-sm"><i class="fas fa-download"></i></a>';
            })
			->addColumn('show_image', function($u){
                if ($u->gambar == NULL){
                    return 'No Image';
                }
                return '<img class="rounded-square" width="50" height="50" src="'. url($u->gambar) .'" alt="">';
            })
			->rawColumns(['show_image','action'])->make(true);
    }

    public function exportPDF($id){
        $projek = Projek::with('kategori', 'label', 'kota.provinsi')->findOrFail($id);
        $data = [
            'projek'    => $projek,
        ];

        $pdf = PDF::loadView('project.exportPDF', $data)->setPaper('a4', 'lanscape');
        return $pdf->download('Projek-'.$projek->nama.'.pdf');
    }
}
