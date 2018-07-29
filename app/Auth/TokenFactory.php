<?php

namespace App\Auth;


use Carbon\Carbon;
use Firebase\JWT\JWT;
use Slim\Settings;

class TokenFactory
{
    /**
     * @var array
     */
    protected $claims;

    /**
     * @var ClaimsFactory
     */
    protected $claimsFactory;

    /**
     * @var Settings
     */
    protected $settings;

    /**
     * TokenFactory constructor.
     * @param ClaimsFactory $claimsFactory
     * @param Settings $settings
     */
    public function __construct(ClaimsFactory $claimsFactory, Settings $settings)
    {
        $this->claimsFactory = $claimsFactory;
        $this->settings = $settings;
    }

    public function build(): array
    {
        $allClaims = [];

        foreach ($this->claimsFactory->getAllClaims() as $claim) {
            $allClaims[$claim] = $this->claimsFactory->make($claim);
        }

        return array_merge($this->claims, $allClaims);
    }

    /**
     * @param array $claims
     * @return string
     */
    public function encode(array $claims): string
    {
        return JWT::encode(
            $claims,
            $this->settings->get('jwt.secret'),
            $this->settings->get('jwt.algo')
        );
    }

    /**
     * @param array $claims
     * @return TokenFactory
     */
    public function withClaims(array $claims): self
    {
        $this->claims = $claims;

        return $this;
    }
}