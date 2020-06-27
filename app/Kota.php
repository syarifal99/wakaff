<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    protected $table = 'kota';
    protected $fillable = ['provinsi_id', 'kota'];

    public function provinsi()
    {
        return $this->belongsTo('App\User', 'provinsi_id');
    }
}
