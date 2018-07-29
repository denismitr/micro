<?php

namespace App\Auth;


use App\Models\User;

class EloquentAuthProvider implements Authenticatable
{
    protected $usernameColumns;

    /**
     * EloquentAuthProvider constructor.
     * @param array $usernameColumns
     */
    public function __construct(array $usernameColumns = ['email'])
    {
        $this->usernameColumns = $usernameColumns;
    }

    /**
     * @param string $username
     * @param string $password
     * @return User|null
     */
    public function byCredentials(?string $username, ?string $password)
    {
        if ( ! $user = $this->resolveUser($username) ) {
            return null;
        }

        if ( ! password_verify($password, $user->password)) {
            return null;
        }

        return $user;
    }

    /**
     * @param $id
     * @return User
     */
    public function byId($id): User
    {
        return User::findOrFail($id);
    }

    /**
     * @param $username
     * @return User|null
     */
    protected function resolveUser($username)
    {
        foreach ($this->usernameColumns as $usernameColumn) {
            $user = User::where($usernameColumn, $username)->first();

            if ($user) {
                return $user;
            }
        }

        return null;
    }
}