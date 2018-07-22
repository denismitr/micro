<?php

namespace App\Providers;


use App\Auth\JwtAuth;
use App\Auth\JwtAuthInterface;
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
            return new JwtAuth();
        });
    }
}