<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';
    public $timestamps = false; // Karena tidak ada created_at/updated_at default

    protected $fillable = ['id_pembeli', 'id_barang', 'tanggal_ditambahkan'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
