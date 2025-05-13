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
        return $this->hasOne(Alamat::class); // Setiap pengguna bisa memiliki 1 alamat default
    }

    public function getAuthPassword()
    {
        return $this->password_pembeli;
    }
}


