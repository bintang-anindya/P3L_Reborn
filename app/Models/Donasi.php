<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    protected $table = 'donasi';
    protected $primaryKey = 'id_donasi';
    protected $casts = [
        'tanggal_donasi' => 'datetime',
    ];

    public $timestamps = false;

    protected $fillable = [
        'id_request', 'id_barang', 'tanggal_donasi', 'nama_penerima', 'id_pegawai'
    ];

    public function request()
    {
        return $this->belongsTo(\App\Models\RequestDonasi::class, 'id_request');
    }

    public function barang()
    {
        return $this->belongsTo(\App\Models\Barang::class, 'id_barang');
    }

    public function penitip()
    {
        return $this->belongsTo(\App\Models\Penitip::class, 'id_penitip');
    }

    public function organisasi()
    {
        return $this->belongsTo(\App\Models\Organisasi::class, 'id_organisasi');
    }


}