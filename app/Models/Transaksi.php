<?php
// app/Models/Transaksi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi'; // Nama tabel yang sesuai dengan tabel di database
    protected $primaryKey = 'id_transaksi'; // Primary key
    public $timestamps = false; // Jika tabel tidak menggunakan timestamp (created_at, updated_at)

    protected $fillable = [
        'tanggal_transaksi', 
        'status_transaksi', 
        'total_harga', 
        'id_pembeli', 
        'id_pegawai'
    ];

    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class, 'id_pembeli');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    public function barangs()
    {
        return $this->belongsToMany(Barang::class, 'junction_transaksi_barang', 'id_transaksi', 'id_barang')
                    ->withPivot('jumlah');
    }

    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class, 'id_transaksi');
    }
}
