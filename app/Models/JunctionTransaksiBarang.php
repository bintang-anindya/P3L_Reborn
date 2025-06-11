<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class JunctionTransaksiBarang extends Authenticatable
{
    protected $table = 'transaksi_barang';
    protected $primaryKey = 'id_transaksiBarang'; 
    public $timestamps = false; 

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