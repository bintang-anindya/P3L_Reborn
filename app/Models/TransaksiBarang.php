<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiBarang extends Model
{
    protected $primaryKey = 'id_transaksiBarang';
    protected $table = 'transaksi_barang';

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }
}