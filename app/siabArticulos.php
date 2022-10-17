<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class siabArticulos extends Model
{
    protected $fillable = [
        'CODART', 'NOMBRE', 'UNIMED', 'PRECIO', 'PRE_PROM', 'idEstado', 'idBodega'
    ];
}
