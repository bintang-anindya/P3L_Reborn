<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Organisasi extends Authenticatable
{
    use HasFactory;
    protected $table = 'organisasi';
    protected $primaryKey = 'id_organisasi';
    public $timestamps = false;

    protected $fillable = [
        'nama_organisasi',
        'username_organisasi',
        'email_organisasi',
        'password_organisasi',
        'alamat_organisasi',
        'no_telp_organisasi',
    ];

    public function requests() {
        return $this->hasMany(Request::class, 'id_organisasi');
    }

    public function getAuthPassword()
    {
        return $this->password_pembeli;
    }

    public function requests()
    {
        return $this->hasMany(RequestDonasi::class, 'id_organisasi');
    }
}
