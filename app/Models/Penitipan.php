<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Penitipan extends Model
{
    protected $table = 'penitipan';

    protected $primaryKey = 'id_penitipan';

    public $timestamps = false;

    protected $fillable = [
        'pesan',
        'id_pegawai',
        'id_penitip',
        'tanggal_masuk',
        'tenggat_waktu',
    ];

    protected $casts = [
        'tanggal_masuk' => 'datetime',
        'tenggat_waktu' => 'datetime',
    ];

    public function barang()
    {
        // return $this->hasOne(Barang::class, 'id_penitipan');
        return $this->hasMany(Barang::class, 'id_penitipan');
    }

    public function penitip()
    {
        return $this->belongsTo(Penitip::class, 'id_penitip');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }
}
