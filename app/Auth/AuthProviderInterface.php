<?php

namespace App\Auth;


interface AuthProviderInterface
{
    /**
     * @param string $username
     * @param string $password
     * @return User|null
     */
    public function byCredentials(?string $username, ?string $password);
}