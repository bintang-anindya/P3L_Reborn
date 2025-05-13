<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Role extends Authenticatable
{
    protected $table = 'role';
    protected $primaryKey = 'id_role'; 
    public $timestamps = false;


}