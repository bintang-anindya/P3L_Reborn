<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pegawai extends Authenticatable
{
    protected $table = 'pegawai';
    protected $primaryKey = 'id_pegawai';
    public $timestamps = false;
    use HasFactory;

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role'); 
    }

    public function getAuthPassword()
    {
        return $this->password_pegawai;
    }
}