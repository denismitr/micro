<?php

namespace App\Auth;


use Carbon\Carbon;
use Slim\Http\Request;
use Slim\Settings;
use Psr\Http\Message\RequestInterface;

class ClaimsFactory
{
    /**
     * @var Carbon
     */
    protected $now;

    /**
     * @var array
     */
    protected $allClaims = [
        'iss',
        'iat',
        'nbf',
        'jti',
        'exp',
    ];

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var Settings
     */
    protected $settings;

    /**
     * ClaimsFactory constructor.
     * @param RequestInterface $request
     * @param Settings $settings
     */
    public function __construct(RequestInterface $request, Settings $settings)
    {
        $this->now = Carbon::now();

        $this->request = $request;
        $this->settings = $settings;
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
        return (string) $this->request->getUri();
    }

    public function iat(): int
    {
        return $this->now->getTimestamp();
    }

    public function nbf(): int
    {
        return $this->now->getTimestamp();
    }

    public function jti(): string
    {
        return bin2hex(str_random(32));
    }

    public function exp(): int
    {
        return $this->now->addMinutes(
            $this->settings->get('jwt.ttl')
        )->getTimestamp();
    }

    public function make(string $claim)
    {
        if ( ! method_exists($this, $claim)) {
            return null;
        }

        return $this->{$claim}();
    }
}