<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class JunctionTransaksiBarang extends Authenticatable
{
    protected $table = 'junction_transaksi_barang'; // Nama tabel jika tidak mengikuti konvensi jamak

    protected $primaryKey = 'id_transaksiBarang'; // Jika primary key bukan 'id'

    public $timestamps = false; // Jika tabel tidak pakai created_at dan updated_at

    protected $fillable = [
        'id_barang',
        'id_transaksi'
    ];

    public function Barang(){
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    public function Transaksi(){
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }
}