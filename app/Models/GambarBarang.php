<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class GambarBarang extends Model
{
    protected $table = 'gambar_barang';

    protected $fillable = [
        'id_barang',
        'path_gambar',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
