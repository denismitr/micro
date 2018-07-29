<?php

namespace App\Auth;


use Carbon\Carbon;

class ClaimsFactory
{
    /**
     * @var Carbon
     */
    protected $now;

    protected $allClaims = [
        'iss',
        'iat',
        'nbf',
        'jti',
        'exp',
    ];

    /**
     * ClaimsFactory constructor.
     */
    public function __construct()
    {
        $this->now = Carbon::now();
    }

    /**
     * @return array
     */
    public function getAllClaims(): array
    {
        return $this->allClaims;
    }

    public function iss(): string
    {
        return '';
    }

    public function iat()
    {
        return $this->now->getTimestamp();
    }

    public function nbf()
    {
        return $this->now->getTimestamp();
    }

    public function jti(): string
    {
        return bin2hex(str_random(32));
    }

    public function exp()
    {
        return $this->now->addMinutes(60)->getTimestamp();
    }

    public function make(string $claim)
    {
        if ( ! method_exists($this, $claim)) {
            return null;
        }

        return $this->{$claim}();
    }
}