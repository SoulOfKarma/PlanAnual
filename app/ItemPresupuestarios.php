<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemPresupuestarios extends Model
{
    protected $fillable = [
        'CODSER','NOMBRE','UNIMED','CODIPRE','NOMBREIPRE',       
    ];
}
