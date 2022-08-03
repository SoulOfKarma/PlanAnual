<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Users extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'id','run','correo_usuario','nombre_usuario','apellido_usuario','anexo',
        'password','idServicio',
       
    ];

    protected $hidden = ['password','remember_token'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims(){
        return [];
    }
}
