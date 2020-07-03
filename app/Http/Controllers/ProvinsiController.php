<?php

namespace App\Http\Controllers;

use App\Provinsi;
use Illuminate\Http\Request;

class ProvinsiController extends Controller
{
    public function index() 
    {
        $provinsi = provinsi::with('kota')->get();
        return $provinsi;
    }
    public function show($id){
        $provinsi = Provinsi::with('kota')->findOrFail($id);
        return $provinsi;
    }
}
