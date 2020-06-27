<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projek extends Model
{
    protected $table = 'projek';
    protected $fillable = ['nama','slug','deskripsi','tenggat_waktu','nominal','gambar','status','kategori_id','label_id','user_id','kota_id','mitra'];

    public function artikel()
    {
        return $this->hasMany(Artikel::class, 'projek_id', 'id');
    }

    public function pendanaan()
    {
        return $this->hasMany(Pendanaan::class, 'projek_id', 'id');
    }

    public function pencairan()
    {
        return $this->hasMany(Pencairan::class, 'projek_id', 'id');
    }
    
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
    
    public function label()
    {
        return $this->belongsTo(Label::class, 'label_id');
    }

    public function kota()
    {
        return $this->belongsTo(Kota::class, 'kota_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mitra()
    {
        return $this->belongsTo(User::class, 'mitra');
    }
}
