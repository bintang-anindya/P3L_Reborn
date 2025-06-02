<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GambarBarang extends Model
{
    protected $table = 'gambar_barang';
    
    protected $primaryKey = 'id_gambar';
    
    public $timestamps = false;
    
    protected $fillable = [
        'path_gambar',
        'id_barang'
    ];
    
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}