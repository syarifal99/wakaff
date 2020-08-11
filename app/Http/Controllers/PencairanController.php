<?php

namespace App\Http\Controllers;
use App\Pencairan;
use App\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class PencairanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $progress = Pencairan::all();
        return view('pencairan.index',['pencairan'=>$progress]);
    }
    public function mitra($id)
    {
        $progress = Pencairan::all()->where('projek_id',$id);
        return view('pencairan.datapencairan',['pencairan'=>$progress,'id'=>$id]);
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
        $this->validate($request, [
			'nominal' 	=> 'required|max:191',
			'deskripsi' => 'required',
			'projek_id' 	=> 'required',
		]);
		$input = $request->all();
		$projek = Pencairan::create([
            'nominal'          => $request->nominal,
            'deskripsi'    	 => $request->deskripsi,
            'projek_id'       => $request->projek_id,
            'user_id'       => Auth::user()->id,
            'admin_id'       =>Auth::user()->id,
        ]);

        if($request->ajax()) return response()->json(['success' =>false, 'message' => 'Pencairan Dana berhasil diajukan']);
        return redirect(route('pencairan.show', $pencairan->id));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pencairan = User::whereHas('mitra_attr')->with('mitra_attr')->get();
        $projek = Pencairan::where('id', $id)
            ->with('user', 'projek')
            ->firstOrFail();

        if(!$projek) return abort(404);

        $data = [
            'projek' => $projek,
            'mitra' => $pencairan,
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
        $pencairan = Pencairan::find($id);
		return $pencairan;
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
			'deskripsi' 	=> 'required',

		]);
		$pencairan = Pencairan::findOrFail($id);
		$input = $request->all();
		$pencairan->update([
			'nominal'           => $request->nominal,
            'deskripsi'     	=> $request->deskripsi,
        ]);
        
        $_user = Auth::user();
        if( $_user->hasRole(['admin']) ){
            $pencairan->update(['status' => isset($request->status)?$request->status: $pencairan->status]);
        }

		if($request->ajax()) return response()->json(['success' =>false, 'message' => 'pencairan berhasil diubah.']);
        return redirect(route('pencairan.show', $pencairan->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pencairan = Pencairan::findOrFail($id);
		$pencairan->delete();

		return response()->json([
			'success' => true,
			'message' => 'pencairan delete.',
		]);
    }
    public function apiPencairan() {
        $user = User::with('mitra_attr')->findOrFail(Auth::user()->id);

        $query = Pencairan::query();
        if( $user->hasRole(['mitra']) ){
            $pencairans = $query->whereHas('projek.mitra', function($q) use($user){
                $q->where('id', $user->mitra_attr->id);
            })->with('projek.mitra','user')->get();
        }else{
            $pencairans = $query->with('projek.mitra','user')->get();
        }

		return Datatables::of($pencairans)
			->addColumn('action', function ($s) {
                return '<div class="btn-group d-flex" role="group">
                    <button onclick="editForm('. $s->id .')" type="button" class="btn btn-info btn-small" data-id="9448"><i class="fa fa-edit"></i></button>
                    <div class="btn-group" role="group">
                        <button class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Status</button>
                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;"> 
                                <a type="button" class="dropdown-item btn_status text-success" data-id="'. $s->id .'" data-status="DISETUJUI"><i class="fas fa-check"></i> DISETUJUI</a>
                                <a type="button" class="dropdown-item btn_status text-danger" data-id="'. $s->id .'" data-status="DITOLAK"><i class="fa fa-fire"></i> DITOLAK</a>
                                <a type="button" class="dropdown-item btn_status text-primary" data-id="'. $s->id .'" data-status="MENUNGGU"><i class="fa fa-fire"></i> MENUNGGU</a>
                            </div>
                        </div>
                    </div>
                </div>';
                // return 
                // '<a onclick="editForm('. $s->id .')" class="btn btn-success btn-icon-split btn-sm mr-2 mb-2"><span class="icon text-white-50"><i class="fas fa-check"></i></span><span class="text text-white"> Approval</span></a>' .
                // '<a onclick="deleteData('. $s->id .')" class="btn btn-danger btn-icon-split btn-sm mr-2 mb-2"><span class="icon text-white-50"><i class="fas fa-trash"></i></span><span class="text text-white"> Delete</span></a>';
			})
			->rawColumns(['show_image','action'])->make(true);
    }
    public function apiMitraPencairan($id) {
        $user = User::with('mitra_attr')->findOrFail(Auth::user()->id);
        $query = Pencairan::query();
        if( $user->hasRole(['mitra']) ){
            $pencairans = $query->where('projek_id',$id)->whereHas('projek.mitra', function($q) use($user){
                $q->where('id', $user->mitra_attr->id);
            })->with('projek.mitra','user')->get();
        }else{
            $pencairans = $query->with('projek.mitra','user')->get();
        }

		return Datatables::of($pencairans)
			->addColumn('action', function ($s) {
                return 
                '<a onclick="editForm('. $s->id .')" class="btn btn-success btn-icon-split btn-sm mr-2 mb-2"><span class="icon text-white-50"><i class="fas fa-check"></i></span><span class="text text-white"> Approval</span></a>' .
                '<a onclick="deleteData('. $s->id .')" class="btn btn-danger btn-icon-split btn-sm mr-2 mb-2"><span class="icon text-white-50"><i class="fas fa-trash"></i></span><span class="text text-white"> Delete</span></a>';
			})
			->rawColumns(['show_image','action'])->make(true);
    }
    
    public function updateStatus(Request $request, $id){
        Pencairan::where('id', $id)->update([
            'status'    => $request->status,
        ]);
        return response()->json(['success' =>false, 'message' => 'Status pencairan berhasil diperbarui.']);
    }
}
