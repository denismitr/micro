<?php

namespace App\Providers;


use App\Auth\ClaimsFactory;
use App\Auth\EloquentAuthProvider;
use App\Auth\FirebaseJwtProvider;
use App\Auth\JwtAuth;
use App\Auth\JwtAuthInterface;
use App\Auth\JwtParser;
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
            $request = $container->get('request');
            $jwtProvider = new FirebaseJwtProvider($settings);
            $parser = new JwtParser($jwtProvider);

            $factory = new TokenFactory(
                new ClaimsFactory($request, $settings),
                $jwtProvider
            );

            return new JwtAuth($auth, $factory, $parser);
        });
    }
}