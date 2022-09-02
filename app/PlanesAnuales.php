<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanesAnuales extends Model
{
    protected $fillable = [
        'CODART','NOMART','UNIMED','PRECIO','C_ENE','C_FEB',
        'C_MAR','C_ABR','C_MAY','C_JUN','C_JUL','C_AGO',
        'C_SEP','C_OCT','C_NOV','C_DIC','C_TOTAL','T_PRECIO',
        'FECING','CODSER','NOMSER','BODEGA','OBS','ANIO',
        'NROPED','idServicio','ZGEN',
       
    ];
}
