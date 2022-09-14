<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PresupuestosAnuales extends Model
{
    protected $fillable = [
        'CODSER','NOMSER','ANIO','P_ANUAL','CODSERN',       
    ];
}
