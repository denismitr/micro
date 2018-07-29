<?php

namespace App\Providers;


use App\Auth\ClaimsFactory;
use App\Auth\EloquentAuthProvider;
use App\Auth\JwtAuth;
use App\Auth\JwtAuthInterface;
use App\Auth\TokenFactory;
use League\Container\ServiceProvider\AbstractServiceProvider;

class AuthServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        JwtAuthInterface::class,
    ];

    public function register()
    {
        $container = $this->getContainer();

        $container->share(JwtAuthInterface::class, function() {
            $auth = new EloquentAuthProvider(['email']);

            $factory = new TokenFactory(new ClaimsFactory());

            return new JwtAuth($auth, $factory);
        });
    }
}