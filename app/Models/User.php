<?php

namespace App\Models;


use App\Auth\JwtSubject;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements JwtSubject
{
    protected $guarded = ['id'];

    protected $hidden = ['password'];

    public function getJwtIdentifier()
    {
        return $this->id;
    }
}