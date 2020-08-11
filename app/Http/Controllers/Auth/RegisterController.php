<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(Request $request){
        
        $this->validate($request, [
            'name'      => 'required|string|max:191',
            'username'  => 'required|string|max:191|unique:users',
            'email'     => 'required|string|email|max:191|unique:users',
            'password'  => 'required|string|confirmed',
            'no_rek'    => 'nullable|min:10',
            'no_hp'     => 'required||min:10',
            'image' 	=> 'nullable|image|max:1999',
        ]);

        $user = User::create([
            'name' => $request->name,
            'no_hp' => $request->no_hp,
            'no_rek' => $request->no_rek,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        $user->syncRoles('user');
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            Session::flash('pesan', 'Selamat Anda telah terdaftar!');
            $user = User::where('email', $request->email)->first();
            if($user->hasRole(['user'])) return redirect()->intended(route('landing')); 
            else return redirect()->intended(route('dashboard'));
        }

        return $request->wantsJson()? new Response('', 201): redirect(route('landing'));
    }
}
