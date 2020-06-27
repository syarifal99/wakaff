<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kabar extends Model
{
    protected $table = 'kabar';
    protected $fillable = ['gambar','judul','konten','projek_id','user_id'];

    public function author()
    {
        return $this->belongsTo(Artikel::class, 'user_id');
    }

    public function projek()
    {
        return $this->belongsTo(Projek::class, 'projek_id');
    }
}
