<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendanaan extends Model
{
    protected $table = 'pendanaan';
    protected $fillable = ['nominal','metode','bukti','keterangan','status','user_id','projek_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function projek()
    {
        return $this->belongsTo(Projek::class, 'projek_id');
    }
}
