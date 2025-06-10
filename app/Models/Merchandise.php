<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchandise extends Model
{
    use HasFactory;

    protected $table = 'merchandise'; // Pastikan nama tabel benar
    protected $primaryKey = 'id_merchandise'; // Pastikan primary key benar
    public $timestamps = false; // Jika tabel tidak menggunakan created_at dan updated_at

    // Jika ingin mendefinisikan relasi ke pembeli_merchandise
    public function klaimPembeli()
    {
        return $this->hasMany(PembeliMerchandise::class, 'id_merchandise', 'id_merchandise');
    }
}