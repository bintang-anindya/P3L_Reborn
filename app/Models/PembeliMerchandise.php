<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembeliMerchandise extends Model
{
    use HasFactory;

    protected $table = 'pembeli_merchandise'; // Pastikan nama tabel benar
    protected $primaryKey = 'id_pembeli_merchandise'; // Pastikan primary key benar
    public $timestamps = false; // Jika tabel tidak menggunakan created_at dan updated_at

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'id_pembeli',
        'id_merchandise',
        'tanggal_ambil_merchandise',
        'status_merchandise',
    ];

    // Relasi ke tabel Pembeli
    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class, 'id_pembeli', 'id_pembeli');
    }

    // Relasi ke tabel Merchandise
    public function merchandise()
    {
        return $this->belongsTo(Merchandise::class, 'id_merchandise', 'id_merchandise');
    }
}