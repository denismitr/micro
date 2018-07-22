<?php

require_once __DIR__ . '/bootstrap/app.php';

$db = $container->get('settings')->get('db');

return [
    'paths' => [
        'migrations' => 'database/migrations',
    ],
    'migration_base_class' => 'App\Database\Migrations\Migration',
    'templates' => [
        'file' => 'app/Database/Migrations/migration.stub'
    ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'default' => [
            "adapter" => $db["driver"],
            'host' => $db["host"],
            'name' => $db['database'],
            'port' => $db['port'],
            'user' => $db['username'],
            'pass' => $db['password'],
        ]
    ]
];