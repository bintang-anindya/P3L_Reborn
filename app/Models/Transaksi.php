<?php
// app/Models/Transaksi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi'; 
    protected $primaryKey = 'id_transaksi'; 
    public $timestamps = false; 

    protected $fillable = [
        'tanggal_transaksi', 
        'status_transaksi', 
        'total_harga', 
        'id_pembeli', 
        'id_pegawai',
        'bukti_transaksi',
        'nomor_transaksi',
        'poin_tukar',
        'metode'
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
        return $this->belongsToMany(Barang::class, 'transaksi_barang', 'id_transaksi', 'id_barang');
    }

    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class, 'id_transaksi');
    }

    public function TransaksiBarang()
    {
        return $this->hasMany(TransaksiBarang::class, 'id_transaksi', 'id_transaksi');
    }

    public function TransaksiBarangs()
    {
        return $this->hasMany(TransaksiBarang::class, 'id_transaksi', 'id_transaksi');
    }

    public function hitungPoinTukar()
    {
        return $this->poin_tukar ?? 0;
    }

    public function barang()
    {
        return $this->belongsToMany(Barang::class, 'transaksi_barang', 'id_transaksi', 'id_barang');
    }

        public function kurir()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai')->where('id_role', 4);
    }



}
