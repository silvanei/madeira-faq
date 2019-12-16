<?php

declare(strict_types=1);

return [
    'db' => [
        'dsn'            => getenv('DB_DSN'),
        'username'       => getenv('DB_USERNAME'),
        'password'       => getenv('DB_PASSWORD'),
        'charset'        => 'utf-8',
        'driver_options' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
        ]
    ]
];
