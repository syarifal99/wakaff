<?php

namespace App\Http\Controllers;
use App\Pencairan;
use App\User;
use App\Projek;
use App\Mitra;
use Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use DB;
class MonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menunggu = Projek::where('status', 'MENUNGGU')->count();
        $disetujui = Projek::where('status', 'DISETUJUI')->count();
        $ditolak = Projek::where('status', 'DITOLAK')->count();
        $data = [
            'menunggu'   => $menunggu,
            'disetujui'   => $disetujui,
            'ditolak'   => $ditolak,
        ];
        return view('monitoring.index',$data);
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
        // $this->validate($request, [
		// 	'nominal' 	=> 'required|max:191',
		// 	'deskripsi' => 'required',
		// 	'projek_id' 	=> 'required',
		// ]);
		// $input = $request->all();
		// $projek = Pencairan::create([
        //     'nominal'          => $request->nominal,
        //     'deskripsi'    	 => $request->deskripsi,
        //     'projek_id'       => $request->projek_id,
        //     'user_id'       => Auth::user()->id,
        //     'admin_id'       =>Auth::user()->id,
        // ]);

        // if($request->ajax()) return response()->json(['success' =>false, 'message' => 'Pencairan Dana berhasil diajukan']);
        // return redirect(route('pencairan.show', $pencairan->id));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     
    public function show($id)
    {
        $user = User::with('mitra_attr')->findOrFail($id);

        $pencairan = DB::table("pencairan as p")
        ->leftjoin('projek as pr', 'p.projek_id', '=', 'pr.id')
        ->leftjoin('users as u', 'pr.mitra_id', '=', 'u.id')
        ->where('u.id', $user->mitra_attr->id)
        ->select(DB::raw("SUM(p.nominal) as total_nominaldana"), DB::raw('MONTH(p.created_at) as date'))->orderBy('date')->get();

        $total_pencairan = [];
        for ($i = 1; $i <= 12; $i++) {
            $total_pencairan[] = [
                'date' => $i,
                'total' => 0,
            ];
        }
        for ($i = 0; $i < count($total_pencairan); $i++) {
            foreach ($pencairan as $key => $c) {
                if ($c->date == $total_pencairan[$i]['date']) {
                    $total_pencairan[$i] = [
                        'date' => $c->date,
                        'total' => $c->total_nominaldana,
                    ];
                }
            }
        }

        $pendanaan = DB::table("pendanaan as p")
        ->leftjoin('projek as pr', 'p.projek_id', '=', 'pr.id')
        ->leftjoin('users as u', 'pr.mitra_id', '=', 'u.id')
        ->where('u.id', $user->mitra_attr->id)
        ->select(DB::raw("SUM(p.nominal) as total_nominaldana"), DB::raw('MONTH(p.created_at) as date'))->orderBy('date')->get();

        $total_pendanaan = [];
        for ($i = 1; $i <= 12; $i++) {
            $total_pendanaan[] = [
                'date' => $i,
                'total' => 0,
            ];
        }
        for ($i = 0; $i < count($total_pendanaan); $i++) {
            foreach ($pendanaan as $key => $c) {
                if ($c->date == $total_pendanaan[$i]['date']) {
                    $total_pendanaan[$i] = [
                        'date' => $c->date,
                        'total' => $c->total_nominaldana,
                    ];
                }
            }
        }
        // $pendanaans = Pendanaan::with(['projek' => function($q) use($id){
        //     $q->where('mitra_id', $id)->get();
        // }])->get();

        // return $pendanaan;

        $project_disetujui = Projek::where('mitra_id', $user->mitra_attr->id)->where('status', 'DISETUJUI')->get();
        $project_ditolak = Projek::where('mitra_id', $user->mitra_attr->id)->where('status', 'DITOLAK')->get();
        $project_menunggu = Projek::where('mitra_id', $user->mitra_attr->id)->where('status', 'MENUNGGU')->get();
        // dd($project_disetujui);

        $data = [
            'project_disetujui' => $project_disetujui,
            'project_ditolak'   => $project_ditolak,
            'project_menunggu'  => $project_menunggu,
            'total_pencairan'   => $total_pencairan,
            'total_pendanaan'   => $total_pendanaan,
            'id'   => $id,
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
        $monitoring = Monitoring::find($id);
		return $monitoring;
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
        // $this->validate($request, [
		// 	'nominal' 	=> 'required|max:191',
		// 	'deskripsi' 	=> 'required',

		// ]);
		// $pencairan = Pencairan::findOrFail($id);
		// $input = $request->all();
		// $pencairan->update([
		// 	'nominal'         => $request->nominal,
        //     'deskripsi'     	=> $request->deskripsi,
        //     'status'        => $request->status,
		// ]);

		// if($request->ajax()) return response()->json(['success' =>false, 'message' => 'pencairan berhasil diubah.']);
        // return redirect(route('pencairan.show', $pencairan->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $pencairan = Pencairan::findOrFail($id);
		// $pencairan->delete();

		// return response()->json([
		// 	'success' => true,
		// 	'message' => 'pencairan delete.',
		// ]);
    }
    public function apiMonitoring() {
        
        $users = User::with(['roles', 'mitra_attr'])
            ->whereHas('roles', function($q){
                $q->where('name', 'mitra');
            })
            ->get();
        return Datatables::of($users)
            ->addColumn('action', function ($u) {
                return '<a  onclick="detail('. $u->id .')" class="btn btn-info btn-icon-split btn-sm"><span class="icon text-white-50"><i class="fas fa-eye"></i></span><span class="text text-white"> Monitoring</span></a>' ;
            })
            ->addColumn('show_image', function ($u) {
                if ($u->image == NULL) {
                    return 'No Image';
                }
                return '<img class="img-profile rounded-circle" width="50" height="50" src="' . url($u->image) . '" alt="">';
            })
            ->rawColumns(['show_image', 'action'])->make(true);
    }
}
