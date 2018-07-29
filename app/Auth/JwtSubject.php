<?php

namespace App\Auth;


interface JwtSubject
{
    public function getJwtIdentifier();
}