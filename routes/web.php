<?php

use App\Controllers\{HomeController, MeController};
use App\Controllers\Auth\{LoginController, RegisterController};
use \App\Auth\JwtAuth;
use \App\Middleware\Authenticate;

$app->get('/', HomeController::class . ':index');
$app->post('/auth/login', LoginController::class . ':login');
$app->post('/auth/register', RegisterController::class . ':register');

$app->get('/me', MeController::class)
    ->add(new Authenticate($container->get(JwtAuth::class)));