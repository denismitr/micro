<?php

namespace App\Auth;


use App\Models\User;

class JwtAuth implements JwtAuthInterface
{
    protected $usernameColumn = 'email';

    public function attempt(?string $username, ?string $password): ?string
    {
        if ( !$user = User::where($this->usernameColumn, $username)->first()) {
            return null;
        }

        if ( ! password_verify($password, $user->password)) {
            return null;
        }

        return 'fake_token';
    }

    /**
     * @param string $password
     * @return string
     */
    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @param string $usernameColumn
     * @return JwtAuth
     */
    public function setUsernameColumn(string $usernameColumn): self
    {
        $this->usernameColumn = $usernameColumn;

        return $this;
    }
}