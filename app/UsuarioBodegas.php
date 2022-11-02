<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioBodegas extends Model
{
    protected $fillable = [
        'run_usuario', 'idBodega', 'descripcionBodega'
    ];
}
