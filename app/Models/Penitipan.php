<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;
use App\Models\Penitip; // Import model Penitip
use App\Models\Pegawai; // Import model Pegawai (untuk CS dan Hunter)
use App\Models\Barang;  // Import model Barang


class Penitipan extends Model
{
    protected $table = 'penitipan';
    protected $primaryKey = 'id_penitipan';
    public $timestamps = false; // Jika tabel tidak punya created_at dan updated_at

    protected $fillable = [
        'pesan',
        'id_pegawai',
        'id_penitip',
        'id_hunter',
        'tanggal_masuk',
        'tenggat_waktu',
    ];

    /**
     * Relasi ke Pegawai
     */
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }

    protected $casts = [
        'tanggal_masuk' => 'datetime',
        'tenggat_waktu' => 'datetime',
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_penitipan');
    }

    public function penitip()
    {
        return $this->belongsTo(Penitip::class, 'id_penitip');
    }

    public function getHunterAttribute()
    {
        if ($this->id_hunter) {
            return Pegawai::find($this->id_hunter);
        }
        return null;
    }
}