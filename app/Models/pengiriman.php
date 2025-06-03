<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    protected $table = 'pengiriman'; // Nama tabel yang sesuai dengan tabel di database
    protected $primaryKey = 'id_pengiriman'; // Primary key
    public $timestamps = false; // Jika tabel tidak menggunakan timestamp (created_at, updated_at)
    
    // Menentukan kolom yang bisa diisi
    protected $fillable = [
        'tanggal_pengiriman', 
        'id_transaksi',
        'tanggal_pengiriman', 
        'id_pegawai'
    ];

    // Relasi ke Transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    // Relasi ke Pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }
}