<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Barang extends Model
{
    protected $table = 'barang'; // Nama tabel jika tidak mengikuti konvensi jamak

    protected $primaryKey = 'id_barang'; // Jika primary key bukan 'id'

    public $timestamps = false; // Jika tabel tidak pakai created_at dan updated_at

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
        'id_kategori',
        'id_penitipan',
    ];

    public function scopeLayakDidonasikan($query)
    {
        return $query->where('status_barang', 'tersedia')
        ->whereDate('tanggal_masuk', '<=', \Carbon\Carbon::now()->subDays(30));
    }

    // Relasi opsional, sesuaikan dengan model Kategori dan Penitipan
    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'id_kategori');
    }

    public function penitipan()
    {
        return $this->hasMany(Penitipan::class, 'id_barang');
    }

}