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
    ->get('settings')
    ->set('displayErrorDetails', getenv('APP_DEBUG') === 'true');

$container->get('settings')->set('name', getenv('APP_NAME'));

$container->get('settings')
    ->set('db', [
        'driver' => getenv('DB_DRIVER'),
        'host' => getenv('DB_HOST'),
        'database' => getenv('DB_DATABASE'),
        'username' => getenv('DB_USERNAME'),
        'password' => getenv('DB_PASSWORD'),
        'charset' => getenv('DB_CHARSET'),
        'collation' => getenv('DB_COLLATION'),
        'prefix' => ''
    ]);


$capsule = new \Illuminate\Database\Capsule\Manager();
$capsule->addConnection($container->get('settings')->get('db'));
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container->addServiceProvider(new \App\Providers\AuthServiceProvider());

require_once __DIR__ . '/../routes/web.php';
