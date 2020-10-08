<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Projek;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = \Auth::user();
        $role = Role::where('name', 'mitra')->withCount('users')->firstOrFail();
        $projek_count = Projek::count();
        $projek_counti = Projek::whereHas('mitra', function ($q) use ($user) {
            if ($user->mitra_attr) $q->where('id', $user->mitra_attr->id);
        })->where('kategori_id', '2')->count();
        $projek_counte = Projek::whereHas('mitra', function ($q) use ($user) {
            if ($user->mitra_attr) $q->where('id', $user->mitra_attr->id);
        })->where('kategori_id', '1')->count();
        $data = [
            'mitra_count'   => $role->users_count,
            'projek_count'   => $projek_count,
            'projek_counti'   => $projek_counti,
            'projek_counte'   => $projek_counte,
        ];

        return view('dashboard', $data);
    }
}
