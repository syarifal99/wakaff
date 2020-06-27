<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Datatables;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('role:admin,staff');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index');
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
        $roleNames = explode("|", $request->role_name);
        $permissionNames = explode("|", $request->permission_name);

        $this->validate($request, [
            'name'      => 'required|string|max:191',
            'username'  => 'required|string|max:191|unique:users',
            'email'     => 'required|string|email|max:191|unique:users',
            'password'  => 'required|string|confirmed',
            'no_rek'    => 'nullable|min:10',
            'no_hp'     => 'required||min:10',
            'image' 	=> 'nullable|image|max:1999',
        ]);

        $input = $request->all();
        $input['image'] = null;
        if ($request->hasFile('image')){
            $input['image'] = '/upload/users/'.str_slug($input['name'], '-').'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('/upload/users/'), $input['image']);
        }

        $user = User::create([
            'name'      => $input['name'],
            'username'  => $input['username'],
            'email'     => $input['email'],
            'password'  => Hash::make($input['password']),
            'no_hp'     => $input['no_hp'],
            'no_rek'    => $input['no_rek'],
            'image'     => $input['image'],
        ]);

        $user->syncRoles($roleNames);
        $user->syncPermissions($permissionNames);

        return response()->json([
           'success'    => true,
           'message'    => 'User created.'
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
        $user = User::with(['roles.permissions', 'permissions'])->findOrFail($id);
        return $user;
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
        $roleNames = explode("|", $request->role_name);
        $permissionNames = explode("|", $request->permission_name);

        $this->validate($request, [
            'name'      => 'required|string|max:191',
            'username'  => 'required|max:191|unique:users,username,'.$id.',id',
            'email'     => 'required|string|email|max:191|unique:users,email,'.$id.',id',
            'password'  => 'confirmed',
            'no_rek'    => 'nullable|min:10',
            'no_hp'     => 'required||min:10',
            'image' 	=> 'nullable|image|max:1999',
        ]);

        $user = User::findOrFail($id);

        $input = $request->all();
        $input['image'] = $user->image;
        if ($request->hasFile('image')){
            if (!$user->image == NULL){
                try {unlink(public_path($user->image));} catch (\Throwable $th) {}
            }
            $input['image'] = '/upload/users/'.str_slug($input['username'], '-').'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('/upload/users/'), $input['image']);
        } else if($input['image_available']=='false') {
			$input['image'] = NULL;
			try {unlink(public_path($user->image));} catch (\Throwable $th) {}
		}

        $user->name = $input['name'];
        $user->username = $input['username'];
        $user->email = $input['email'];
        $user->no_hp = $input['no_hp'];
        $user->no_rek = $input['no_rek'];
        $user->image = $input['image'];
        if($input['password']) $user->password = Hash::make($input['password']);

        $user->syncRoles($roleNames);
        $user->syncPermissions($permissionNames);
        $user->save();
        
        return response()->json([
            'success'    => true,
            'message'    => 'User updated.'
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
        $user->delete();

        return response()->json([
            'success'    => true,
            'message'    => 'User deleted.'
        ]);
    }

    public function apiUsers()
    {
        $users = User::with(['roles'])->get();

        return Datatables::of($users)
            ->addColumn('action', function($user){

                // '<a  onclick="editRole('. $role->id .')" class="btn btn-info btn-icon-split btn-sm"><span class="icon text-white-50"><i class="fas fa-edit"></i></span><span class="text text-white"> Edit</span></a>' .
                // ' <a onclick="deleteRole('. $role->id .')" class="btn btn-danger btn-icon-split btn-sm"><span class="icon text-white-50"><i class="fas fa-trash"></i></span><span class="text text-white"> Delete</span></a>'
                
                $btn = '<a onclick="editForm('. $user->id .')" class="btn btn-info btn-icon-split btn-sm mr-2 mb-2"><span class="icon text-white-50"><i class="fas fa-edit"></i></span><span class="text text-white"> Edit</span></a> ';
                if($user->id != Auth::user()->id){
                    $btn .= '<a onclick="deleteData('. $user->id .')" class="btn btn-danger btn-icon-split btn-sm"><span class="icon text-white-50"><i class="fas fa-trash"></i></span><span class="text text-white"> Delete</span></a>';
                }
                return $btn;
            })
            ->addColumn('show_image', function($user){
                if ($user->image == NULL){
                    return 'No Image';
                }
                return '<img class="rounded-square" width="50" height="50" src="'. url($user->image) .'" alt="">';
            })
			->rawColumns(['show_image','action'])->make(true);
    }
}
