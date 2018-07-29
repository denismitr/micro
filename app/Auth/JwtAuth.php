<?php

namespace App\Auth;


use App\Models\User;

class JwtAuth implements JwtAuthInterface
{
    /**
     * @var AuthProviderInterface
     */
    protected $auth;
    /**
     * @var TokenFactory
     */
    protected $factory;

    /**
     * JwtAuth constructor.
     * @param AuthProviderInterface $auth
     * @param TokenFactory $factory
     */
    public function __construct(AuthProviderInterface $auth, TokenFactory $factory)
    {
        $this->auth = $auth;
        $this->factory = $factory;
    }

    /**
     * @param null|string $username
     * @param null|string $password
     * @return boolean|string
     */
    public function attempt(?string $username, ?string $password): ?string
    {
        if ( ! $user = $this->auth->byCredentials($username, $password)) {
            return false;
        }

        return $this->fromSubject($user);
    }

    /**
     * @param string $password
     * @return string
     */
    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    protected function fromSubject(JwtSubject $subject): string
    {
        return $this->factory->encode($this->makePayload($subject));
    }

    protected function makePayload(JwtSubject $subject): array
    {
        return $this->factory->withClaims(
            $this->getClaimsForSubject($subject)
        )->build();
    }

    protected function getClaimsForSubject(JwtSubject $subject): array
    {
        return [
            'sub' => $subject->getJwtIdentifier(),
        ];
    }
}