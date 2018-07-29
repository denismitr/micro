<?php

namespace App\Auth;


interface JwtProvider
{
    public function encode(array $claims): string;

    public function decode(string $token): DecodedToken;
}