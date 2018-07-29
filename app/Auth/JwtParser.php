<?php
/**
 * Created by PhpStorm.
 * User: denismitr
 * Date: 30.07.2018
 * Time: 0:57
 */

namespace App\Auth;


class JwtParser
{
    /**
     * @var JwtProvider
     */
    protected $jwtProvider;

    /**
     * JwtParser constructor.
     * @param JwtProvider $jwtProvider
     */
    public function __construct(JwtProvider $jwtProvider)
    {
        $this->jwtProvider = $jwtProvider;
    }

    public function decode(string $token)
    {
        return $this->jwtProvider->decode(
            $this->extractBearer($token)
        );
    }

    protected function extractBearer(string $token): ?string
    {
        if (preg_match('/^Bearer\s(\S)/', $token, $matches)) {
            return $matches[0] ?? null;
        }

        return null;
    }
}