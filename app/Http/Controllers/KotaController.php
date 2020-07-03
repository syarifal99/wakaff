<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kota;

class KotaController extends Controller
{
    public function index() 
    {
        $kota = Kota::all();
        return $kota;
    }
    public function show(Request $request) 
    {
        $kota = Kota::where('id_provinsi', $request->id_provinsi)->get();
        return $kota;
    }
}
