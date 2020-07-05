<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Projek;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function dashboard(){
        $role = Role::where('name', 'mitra')->withCount('users')->firstOrFail();
        $projek_count = Projek::count();
        $data = [
            'mitra_count'   => $role->users_count,
            'projek_count'   => $projek_count,
        ];
        
        return view('dashboard', $data);
    }
}