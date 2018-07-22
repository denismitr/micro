<?php

require_once __DIR__ . '/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__ . '/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

$app = new \Jenssegers\Lean\App();

$container = $app->getContainer();

$container
    ->add('settings')
    ->set('displayErrorDetails', getenv('APP_DEBUG') === 'true')
    ->set('name', getenv('APP_NAME'));

require_once __DIR__ . '/../routes/web.php';
