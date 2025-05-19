<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestDonasi extends Model
{
    use HasFactory;

    protected $table = 'request_donasi';
    public $timestamps = false;
    protected $primaryKey = 'id_request';
    protected $fillable = [
        'keterangan_request',
        'id_organisasi', 
        'status_donasi'];

    public function organisasi()
    {
        return $this->belongsTo(Organisasi::class, 'id_organisasi');
    }
}