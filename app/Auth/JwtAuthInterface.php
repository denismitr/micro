<?php

namespace App\Auth;


interface JwtAuthInterface
{
    public function attempt(?string $username, ?string $password): ?string;

    public function hashPassword(string $password): string;
}