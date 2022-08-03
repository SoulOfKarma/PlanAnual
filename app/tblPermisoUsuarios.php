<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tblPermisoUsuarios extends Model
{
    protected $fillable = [
        'run_usuario', 'permiso_usuario', 'estado_login'
    ];
}
