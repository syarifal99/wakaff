<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Kabar;
use Yajra\DataTables\DataTables;
use Auth;

class KabarController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('kabar.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		// return $request;
		$this->validate($request, [
			'judul' 	=> 'required|max:191',
			'gambar' 	=> 'nullable|image|max:1999',
			'projek_id' => 'required',
			'konten' 	=> 'required',
		]);
		$input = $request->all();
        $input['gambar'] = null;
        if ($request->hasFile('gambar')){
            $input['gambar'] = '/upload/kabar/' . str_slug($input['judul'], '-') . '.' . $request->gambar->getClientOriginalExtension();
            $request->gambar->move(public_path('/upload/kabar/'), $input['gambar']);
        }
		$projek = Kabar::create([
            'judul'          => $request->judul,
            'gambar'         => $input['gambar'],
            'konten'    	 => $request->konten,
            'projek_id'       => $request->projek_id,
            'user_id'       => Auth::user()->id,
        ]);

        if($request->ajax()) return response()->json(['success' =>false, 'message' => 'Projek berhasil dibuat.']);
        return redirect(route('kabar.show', $kabar->id));

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		$kabar = User::whereHas('mitra_attr')->with('mitra_attr')->get();
        $projek = Projek::where('id', $id)
            ->with('user', 'projek')
            ->firstOrFail();

        if(!$projek) return abort(404);

        $data = [
            'projek' => $projek,
            'mitra' => $kabar,
        ];
        return $data;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$kabar = Kabar::find($id);
		return $kabar;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$this->validate($request, [
			'judul' 	=> 'required|max:191',
			'gambar' 	=> 'nullable|image|max:1999',
			'konten' 	=> 'required',
			// 'name' 		=> 'required|max:191',
			// 'address' 	=> 'required',
			// 'phone' 	=> 'required|min:10',
			// 'email' 	=> 'nullable|email|unique:kabars,email,'.$id.',id',
			// 'gambar' 	=> 'nullable|gambar|max:1999',
		]);
		$kabar = Kabar::findOrFail($id);
		$input = $request->all();
        $input['gambar'] = $kabar->gambar;
        if ($request->hasFile('gambar')){
            if (!$kabar->gambar == NULL){
                try {unlink(public_path($kabar->gambar));} catch (\Throwable $th) {}
            }
            $input['gambar'] = '/upload/kabar/'.str_slug($input['judul'], '-').'.'.$request->gambar->getClientOriginalExtension();
            $request->gambar->move(public_path('/upload/kabar/'), $input['gambar']);
		} else if($input['image_available']=='false') {
			$input['gambar'] = NULL;
			try {unlink(public_path($kabar->gambar));} catch (\Throwable $th) {}
		}
		$kabar->update([
			'judul'         => $request->judul,
            'gambar'        => $input['gambar'],
            'konten'     	=> $request->konten,
		]);

		if($request->ajax()) return response()->json(['success' =>false, 'message' => 'Kabar berhasil diubah.']);
        return redirect(route('kabar.show', $kabar->slug));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$kabar = Kabar::findOrFail($id);
		// if($kabar->products()->exists()){
		// 	return response()->json([
        //         'success'    => true,
        //         'message'    => 'Can\'t delete this kabar. Because there are products with this kabar.'
        //     ]);
		// }
		$kabar->delete();

		return response()->json([
			'success' => true,
			'message' => 'Kabar delete.',
		]);
	}

	public function apiKabar() {
		$kabars = Kabar::with('projek')->get();

		return Datatables::of($kabars)
			->addColumn('action', function ($s) {
                return '<a  onclick="editForm('. $s->id .')" class="btn btn-info btn-icon-split btn-sm mr-2 mb-2"><span class="icon text-white-50"><i class="fas fa-edit"></i></span><span class="text text-white"> Edit</span></a>' .
                ' <a onclick="deleteData('. $s->id .')" class="btn btn-danger btn-icon-split btn-sm"><span class="icon text-white-50"><i class="fas fa-trash"></i></span><span class="text text-white"> Delete</span></a>';
			})
			->addColumn('show_image', function($s){
                if ($s->gambar == NULL){
                    return 'No Image';
                }
                return '<img class="rounded-square" width="50" height="50" src="'. url($s->gambar) .'" alt="">';
            })
			->rawColumns(['show_image','action'])->make(true);
	}
}
