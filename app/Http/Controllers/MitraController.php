<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mitra;
use App\User;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class MitraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mitra.index');
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
            'name'      => 'required|max:191',
            'username'  => 'required|unique:users',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|string|min:8|confirmed',
            'no_rek'    => 'nullable|min:10',
            'no_hp'     => 'required||min:10',
            'pj'        => 'required',
            'image'     => 'nullable|image|max:1999',
        ]);

        $input = $request->all();
        $input['image'] = null;
        if ($request->hasFile('image')) {
            $input['image'] = '/upload/users/' . str_slug($input['name'], '-') . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('/upload/users/'), $input['image']);
        }

        $user = User::create([
            'name'      => $input['name'],
            'username'  => $input['username'],
            'email'     => $input['email'],
            'password'  => Hash::make($input['password']),
            'no_rek'    => $input['no_rek'],
            'no_hp'     => $input['no_hp'],
            'image'     => $input['image'],
        ]);

        $user->assignRole('mitra');

        $mitra = Mitra::create([
            'user_id'   => $user->id,
            'pj'        => $input['pj'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Mitra created.',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::with('mitra_attr')->findOrFail($id);
        return $users;
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
            'name'      => 'required|max:191',
            'email'     => 'required|email|unique:users,email,' . $id . ',id',
            'username'  => 'required|unique:users,username,' . $id . ',id',
            'no_rek'    => 'nullable|min:10',
            'no_hp'     => 'required||min:10',
            'pj'        => 'required',
            'image'     => 'nullable|image|max:1999',
        ]);

        $user = User::with(['roles', 'mitra_attr'])->findOrFail($id);
        $input = $request->all();
        $input['image'] = $user->image;
        if ($request->hasFile('image')) {
            if (!$user->image == NULL) {
                try {
                    unlink(public_path($user->image));
                } catch (\Throwable $th) {
                }
            }
            $input['image'] = '/upload/users/' . str_slug($input['username'], '-') . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('/upload/users/'), $input['image']);
        } else if ($input['image_available'] == 'false') {
            $input['image'] = NULL;
            try {
                unlink(public_path($user->image));
            } catch (\Throwable $th) {
            }
        }
        $user->name = $input['name'];
        $user->username = $input['username'];
        $user->email = $input['email'];
        $user->no_hp = $input['no_hp'];
        $user->no_rek = $input['no_rek'];
        $user->image = $input['image'];
        if($input['password']) $user->password = Hash::make($input['password']);
        $user->save();
        
        if($user->mitra_attr()->exists()){
            $user->mitra_attr()->update([
                'pj'    => $input['pj'],
            ]);
        }else{
            $user->mitra_attr()->create([
                'user_id'   => $user->id,
                'pj'        => $input['pj'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Mitra updated.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->projek()->exists()) {
            return response()->json([
                'success'    => true,
                'message'    => 'Can\'t delete this mitra. Because there are projects relate to this mitra.'
            ]);
        }
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mitra deleted.',
        ]);
    }

    public function apiMitra()
    {
        $users = User::with(['roles', 'mitra_attr'])
            ->whereHas('roles', function($q){
                $q->where('name', 'mitra');
            })
            ->get();
        return Datatables::of($users)
            ->addColumn('action', function ($u) {
                return '<a  onclick="editForm('. $u->id .')" class="btn btn-info btn-icon-split btn-sm mr-2 mb-2"><span class="icon text-white-50"><i class="fas fa-edit"></i></span><span class="text text-white"> Edit</span></a>' .
                ' <a onclick="deleteData('. $u->id .')" class="btn btn-danger btn-icon-split btn-sm"><span class="icon text-white-50"><i class="fas fa-trash"></i></span><span class="text text-white"> Delete</span></a>';
            })
            ->addColumn('show_image', function ($u) {
                if ($u->image == NULL) {
                    return 'No Image';
                }
                return '<img class="rounded-square" width="50" height="50" src="' . url($u->image) . '" alt="">';
            })
            ->rawColumns(['show_image', 'action'])->make(true);
    }
}
