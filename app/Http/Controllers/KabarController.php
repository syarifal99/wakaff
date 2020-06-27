<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Kabar;
use Yajra\DataTables\DataTables;

class KabarController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('kabars.index');
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
		$this->validate($request, [
			'name' 		=> 'required|max:191',
			'address' 	=> 'required',
			'phone' 	=> 'required|min:10',
			'email' 	=> 'nullable|email|unique:kabars',
			'image' 	=> 'nullable|image|max:1999',
		]);

		$input = $request->all();
        $input['image'] = null;
        if ($request->hasFile('image')){
            $input['image'] = '/upload/kabars/'.str_slug($input['name'], '-').'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('/upload/kabars/'), $input['image']);
        }
		Kabar::create($input);

		return response()->json([
			'success' => true,
			'message' => 'Kabars created.',
		]);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
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
			'name' 		=> 'required|max:191',
			'address' 	=> 'required',
			'phone' 	=> 'required|min:10',
			'email' 	=> 'nullable|email|unique:kabars,email,'.$id.',id',
			'image' 	=> 'nullable|image|max:1999',
		]);
		$kabar = Kabar::findOrFail($id);
		$input = $request->all();
        $input['image'] = $kabar->image;
        if ($request->hasFile('image')){
            if (!$kabar->image == NULL){
                try {unlink(public_path($kabar->image));} catch (\Throwable $th) {}
            }
            $input['image'] = '/upload/kabars/'.str_slug($input['name'], '-').'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('/upload/kabars/'), $input['image']);
		} else if($input['image_available']=='false') {
			$input['image'] = NULL;
			try {unlink(public_path($kabar->image));} catch (\Throwable $th) {}
		}
		$kabar->update($input);

		return response()->json([
			'success' => true,
			'message' => 'Kabar updated.',
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$kabar = Kabar::findOrFail($id);
		if($kabar->products()->exists()){
			return response()->json([
                'success'    => true,
                'message'    => 'Can\'t delete this kabar. Because there are products with this kabar.'
            ]);
		}
		$kabar->delete();

		return response()->json([
			'success' => true,
			'message' => 'Kabar delete.',
		]);
	}

	public function apiKabars() {
		$kabars = Kabar::all();

		return Datatables::of($kabars)
			->addColumn('action', function ($s) {
				return '<a onclick="editForm(' . $s->id . ')" class="waves-effect waves-light btn-small"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
				'<a onclick="deleteData(' . $s->id . ')" class="waves-effect waves-light btn-small red lighten-2"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
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
