<?php

namespace App\Auth;


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
     * @var JwtProvider
     */
    protected $encoder;

    /**
     * TokenFactory constructor.
     * @param ClaimsFactory $claimsFactory
     * @param JwtProvider $encoder
     */
    public function __construct(ClaimsFactory $claimsFactory, JwtProvider $encoder)
    {
        $this->claimsFactory = $claimsFactory;
        $this->encoder = $encoder;
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
        return $this->encoder->encode($claims);
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