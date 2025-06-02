<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Balasan extends Model
{
    protected $table = 'balasan';
    protected $primaryKey = 'id_balasan';
    public $timestamps = false; // Jika tabel tidak punya created_at dan updated_at

    protected $fillable = [
        'isi_balasan',
    ];

    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class, 'id_pembeli');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    public function diskusi()
    {
        return $this->belongsTo(Diskusi::class, 'id_diskusi');
    }

    public function balasan()
    {
        return $this->hasMany(Balasan::class, 'id_diskusi');
    }

}