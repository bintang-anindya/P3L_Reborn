<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;

class Penitipan extends Model
{
    protected $table = 'penitipan';
    protected $primaryKey = 'id_penitipan';
    public $timestamps = false; // Jika tabel tidak punya created_at dan updated_at

    protected $fillable = [
        'pesan',
        'id_pegawai',
        'id_penitip',
    ];

    /**
     * Relasi ke Pegawai
     */
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }

    public function penitip()
    {
        return $this->belongsTo(Penitip::class, 'id_penitip');
    }
}