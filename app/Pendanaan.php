<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendanaan extends Model
{
    protected $table = 'pendanaan';
    protected $fillable = ['nominal','metode','bukti','keterangan','status','user_id','projek_id','unit','tanggal'];
    protected $appends = ['nominal_uang','total_pendanaan'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function projek() {
        return $this->belongsTo(Projek::class, 'projek_id');
    }

    public function jenis() {
        return $this->belongsToMany('App\Jenis');
    }

    public function getNominalUangAttribute()
    {
        return 'Rp. '.number_format($this->nominal);
    }
    public function getTotalPendanaanAttribute()
    {
        return $this->sum('nominal');
    }
}
