<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

}