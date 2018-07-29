<?php

namespace App\Auth;


use Firebase\JWT\JWT;
use Slim\Settings;

class FirebaseJwtProvider implements JwtProvider
{
    /**
     * @var Settings
     */
    protected $settings;

    /**
     * FirebaseJwtProvider constructor.
     * @param Settings $settings
     */
    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @param array $claims
     * @return string
     */
    public function encode(array $claims): string
    {
        return JWT::encode($claims, $this->getSecret(), $this->getAlgorithm());
    }

    /**
     * @param string $token
     * @return DecodedToken
     */
    public function decode(string $token): DecodedToken
    {
        return new DecodedToken(
            JWT::decode($token, $this->getSecret(), $this->getAlgorithm())
        );
    }

    /**
     * @return string
     */
    protected function getSecret(): string
    {
        return $this->settings->get('jwt.secret');
    }

    /**
     * @return string
     */
    protected function getAlgorithm(): string
    {
        return $this->settings->get('jwt.algo');
    }
}