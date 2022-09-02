<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PresupuestosAnuales extends Model
{
    protected $fillable = [
        'CODSER','NOMSER','BODEGA','ANIO','P_ANUAL','P_ENE',
        'P_FEB','P_MAR','P_ABR','P_MAY','P_JUN','P_JUL',
        'P_AGO','P_SEP','P_OCT','P_NOV','P_DIC','CODSERN',       
    ];
}
