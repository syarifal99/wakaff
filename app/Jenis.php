<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    protected $table = 'jenis';
    protected $guarded = [];

    public function proyek()
    {
        return $this->belongsToMany('App\Projek');
    }
}
