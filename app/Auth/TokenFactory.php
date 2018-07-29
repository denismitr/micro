<?php

namespace App\Auth;


use Carbon\Carbon;

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
     * TokenFactory constructor.
     * @param ClaimsFactory $claimsFactory
     */
    public function __construct(ClaimsFactory $claimsFactory)
    {
        $this->claimsFactory = $claimsFactory;
    }

    public function make(): array
    {
        $allClaims = [];

        foreach ($this->claimsFactory->getAllClaims() as $claim) {
            $allClaims[$claim] = $this->claimsFactory->make($claim);
        }

        return array_merge($this->claims, $allClaims);
    }

    public function encode()
    {
        
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