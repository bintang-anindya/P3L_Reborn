<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'id_kategori',
        'id_penitipan',
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

}