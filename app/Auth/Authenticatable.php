<?php

namespace App\Auth;


use App\Models\User;

interface Authenticatable
{
    /**
     * @param string $username
     * @param string $password
     * @return User|null
     */
    public function byCredentials(?string $username, ?string $password);

    /**
     * @param $id
     * @return User
     */
    public function byId($id): User;
}