<?php

use App\Controllers\HomeController;
use App\Controllers\Auth\{LoginController, RegisterController};

$app->get('/', HomeController::class . ':index');
$app->post('/auth/login', LoginController::class . ':login');
$app->post('/auth/register', RegisterController::class . ':register');