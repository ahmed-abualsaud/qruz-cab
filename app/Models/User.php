<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    
    protected $guarded = [];

    protected $hidden = ['password'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }
}
