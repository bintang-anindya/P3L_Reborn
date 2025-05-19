<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JunctionTransaksiBarang extends Model
{
    protected $table = 'transaksiBarang'; // Pastikan tabel sesuai dengan nama tabel pivot di database

    protected $primaryKey = 'id_transaksiBarang'; // Menentukan primary key

    // Tabel pivot biasanya tidak memiliki timestamp, pastikan ini sesuai dengan tabel di DB
    public $timestamps = false;

    // Menentukan kolom yang bisa diisi
    protected $fillable = [
        'id_transaksi', 
        'id_barang'
    ];

    // Relasi ke transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    // Relasi ke barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}