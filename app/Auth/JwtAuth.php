<?php

namespace App\Auth;


use App\Models\User;

class JwtAuth implements JwtAuthInterface
{
    /**
     * @var Authenticatable
     */
    protected $auth;

    /**
     * @var TokenFactory
     */
    protected $factory;

    /**
     * @var JwtParser
     */
    private $parser;

    /**
     * @var User
     */
    protected $user = null;

    /**
     * JwtAuth constructor.
     * @param Authenticatable $auth
     * @param TokenFactory $factory
     * @param JwtParser $parser
     */
    public function __construct(Authenticatable $auth, TokenFactory $factory, JwtParser $parser)
    {
        $this->auth = $auth;
        $this->factory = $factory;
        $this->parser = $parser;
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
     * @param string $token
     * @return $this
     */
    public function authenticate(string $token)
    {
        $this->user = $this->auth->byId(
            $this->parser->decode($token)->getSubject()
        );

        return $this;
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

    /**
     * @param JwtSubject $subject
     * @return array
     */
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