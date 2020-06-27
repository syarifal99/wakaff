<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'provinsi';

    protected $fillable = ['provinsi'];

    public function kota()
    {
        return $this->hasMany(Kota::class, 'provinsi_id', 'id');
    }
}
