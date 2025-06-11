<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Penitipan;

class Penitip extends Authenticatable
{
    protected $table = 'penitip';
    protected $primaryKey = 'id_penitip';
    public $timestamps = false;
    use HasFactory;

    protected $fillable = [
        'nama_penitip',
        'username_penitip',
        'password_penitip',
        'nik',
        'email_penitip',
        'no_telp_penitip',
        'poin_penitip',
        'saldo_penitip',
        'foto_ktp',
        'total_rating',
        'jumlah_perating',
    ];

    public function getAuthPassword()
    {
        return $this->password_pembeli;
    }

    public function penitipan()
    {
        return $this->hasMany(Penitipan::class, 'id_penitip');
    }

    public function barang()
    {
        return Barang::whereHas('penitipan.penitip', function ($query) {
            $query->where('id_penitip', $this->id_penitip);
        });
    }

    // Method untuk menghitung total produk terjual
    public function getTotalProdukTerjual()
    {
        return DB::table('transaksi_barang')
            ->join('barang', 'transaksi_barang.id_barang', '=', 'barang.id_barang')
            ->join('penitipan', 'barang.id_penitipan', '=', 'penitipan.id_penitipan')
            ->where('penitipan.id_penitip', $this->id_penitip)
            ->count();
    }

    // Method untuk menghitung rata-rata rating
    public function getAverageRating()
    {
        if ($this->jumlah_perating > 0) {
            return round($this->total_rating / $this->jumlah_perating, 1);
        }
        return 0;
    }

    // Method untuk menambah rating baru
    public function addRating($newRating)
    {
        $this->total_rating += $newRating;
        $this->jumlah_perating += 1;
        $this->save();
    }

    // Method untuk mengupdate rating (jika diperlukan)
    public function updateRating($oldRating, $newRating)
    {
        $this->total_rating = $this->total_rating - $oldRating + $newRating;
        $this->save();
    }

    // Accessor untuk mendapatkan rata-rata rating (opsional)
    public function getAverageRatingAttribute()
    {
        return $this->getAverageRating();
    }

    // Accessor untuk mendapatkan total produk terjual (opsional)
    public function getTotalProdukTerjualAttribute()
    {
        return $this->getTotalProdukTerjual();
    }
}