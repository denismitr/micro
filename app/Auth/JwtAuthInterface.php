<?php

namespace App\Auth;


interface JwtAuthInterface
{
    public function attempt(?string $username, ?string $password): ?string;

    public function authenticate(string $token);

    public function hashPassword(string $password): string;
}