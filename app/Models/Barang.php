<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Penitipan; // Import model Penitipan
use App\Models\Kategori;  // Import model Kategori

class Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    public $timestamps = false;

    protected $fillable = [
        'nama_barang',
        'gambar_barang',
        'berat',
        'status_barang',
        'tanggal_garansi',
        'deskripsi_barang',
        'tanggal_masuk',
        'tanggal_keluar',
        'tenggat_waktu',
        'harga_barang',
        'tanggal_ambil',
        'komisi_hunter',
        'komisi_reusemart', 
        'bonus_penitip',
        'id_kategori',
        'id_penitipan',
        'status_perpanjangan',
    ];

    protected $casts = [
        'tanggal_masuk' => 'datetime',
        'tenggat_waktu' => 'datetime',
        'tanggal_garansi' => 'datetime',
        'harga_barang' => 'decimal:2'
    ];

    public function scopeLayakDidonasikan($query)
    {
        return $query->where('status_barang', 'untuk donasi');
    }
  
    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'id_kategori');
    }

    public function penitipan()
    {

        return $this->belongsTo(Penitipan::class, 'id_penitipan');
    }

    public function penitip()
    {
        return $this->belongsTo(Penitip::class, 'id_penitipan');
    }

    public function gambarTambahan()
    {
        return $this->hasMany(GambarBarang::class, 'id_barang');
    }

    public function transaksiBarang()
    {
        return $this->hasMany(TransaksiBarang::class, 'id_barang');
    }

    public function getPenitipAttribute()
    {
        return $this->penitipan->penitip ?? null;
    }

}