<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrecioArticulos extends Model
{
    protected $fillable = [
        'CODART','PRE_PROM','PRE2',    
    ];
}
