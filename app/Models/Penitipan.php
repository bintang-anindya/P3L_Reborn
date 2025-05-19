<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Penitipan extends Model
{
    protected $table = 'penitipan';

    protected $primaryKey = 'id_penitipan';

    public $timestamps = false;

    public function penitip()
    {
        return $this->belongsTo(Penitip::class, 'id_penitip');
    }
}
