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
        return view('pencairan.index');
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
        $projek = Projek::where('id', $id)
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
    public function apiPencairan() {
		$pencairans = Pencairan::with('projek')->get();

		return Datatables::of($pencairans)
			->addColumn('action', function ($s) {
                return '<a  onclick="editForm('. $s->id .')" class="btn btn-info btn-icon-split btn-sm mr-2 mb-2"><span class="icon text-white-50"><i class="fas fa-edit"></i></span><span class="text text-white"> Edit</span></a>' .
                ' <a onclick="deleteData('. $s->id .')" class="btn btn-danger btn-icon-split btn-sm"><span class="icon text-white-50"><i class="fas fa-trash"></i></span><span class="text text-white"> Delete</span></a>';
			})
			->rawColumns(['show_image','action'])->make(true);
	}
}
