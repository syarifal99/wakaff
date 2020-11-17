<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function myProfile($id)
    {
        $user = User::with(['roles.permissions', 'permissions'])->findOrFail($id);
        return $user;
    }

    public function updateProfile(Request $request, $id)
    {
        $this->validate($request, [
            'name'      => 'required|string|max:191',
            'username'  => 'required|max:191|unique:users,username,' . $id . ',id',
            'email'     => 'required|string|email|max:191|unique:users,email,' . $id . ',id',
            'password_new'  => 'required',
            'no_rek'    => 'nullable|min:10',
            'no_hp'     => 'required||min:10',
            'image'     => 'nullable|image|max:1999',
        ]);

        if ($request->password_new != $request->password_confirmation) {
            return response()->json([
                "errors" =>  [
                    "password_new" => "Konfirmasi password baru tidak cocok."
                ]
            ], 401);
        }

        $user = User::findOrFail($id);
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
        if (Hash::check($request->password, $user->password)) {
            $user->password = Hash::make($input['password_new']);
        } else {
            return response()->json([
                "errors" =>  [
                    "password" => "Password Lama tidak cocok"
                ]
            ], 401);
        }

        $user->save();

        return response()->json([
            'success'    => true,
            'message'    => 'Profil berhasil diedit.'
        ]);
    }
}
