<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pembeli extends Authenticatable
{
    protected $table = 'pembeli';
    protected $primaryKey = 'id_pembeli';
    public $timestamps = false;

    protected $fillable = [
        'nama_pembeli',
        'username_pembeli',
        'password_pembeli',
        'email_pembeli',
        'poin_pembeli',
        'no_telp_pembeli',
        'id_alamat'
    ];

    public function alamat()
    {
        return $this->belongsTo(Alamat::class, 'id_alamat');
    }

    public function getAuthPassword()
    {
        return $this->password_pembeli;
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_pembeli');
    }
}