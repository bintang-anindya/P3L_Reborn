<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori_barang';
    protected $primaryKey = 'id_kategori';
    public $timestamps = false;
}
