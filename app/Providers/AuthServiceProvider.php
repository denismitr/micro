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

        $container->share(JwtAuthInterface::class, function() use ($container) {
            $auth = new EloquentAuthProvider(['email']);
            $settings = $container->get('settings');

            $factory = new TokenFactory(
                new ClaimsFactory($container->get('request'), $settings),
                $settings
            );

            return new JwtAuth($auth, $factory);
        });
    }
}