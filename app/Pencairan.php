<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pencairan extends Model
{
    protected $table = 'pencairan';
    protected $fillable = ['nominal', 'deskripsi', 'status', 'projek_id', 'user_id', 'admin_id'];

    public function user() //mitra yang mengajukan pencairan
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin() //admin yang acc pencairan
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
