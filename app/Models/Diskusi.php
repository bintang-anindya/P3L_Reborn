<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Diskusi extends Model
{
    protected $table = 'diskusi';
    protected $primaryKey = 'id_diskusi';
    public $timestamps = false; // Jika tabel tidak punya created_at dan updated_at

    protected $fillable = [
        'id_pembeli',
        'id_barang',
        'isi_diskusi',
        'tanggal_diskusi',
        'id_diskusi_induk' // jika nanti kamu butuh relasi diskusi induk
    ];


    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class, 'id_pembeli');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    // App\Models\Diskusi.php
    public function balasan()
    {
        return $this->hasMany(Balasan::class, 'id_diskusi');
    }
    
    public function induk()
    {
        return $this->belongsTo(Diskusi::class, 'id_diskusi_induk');
    }

    public function anak()
    {
        return $this->hasMany(Diskusi::class, 'id_diskusi_induk');
    }


}