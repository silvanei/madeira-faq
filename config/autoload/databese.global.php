<?php

declare(strict_types=1);

return [
    'db' => [
        'dsn'            => 'mysql:dbname=madeira_faq;host=mysql-db;port:3306',
        'username'       => 'root',
        'password'       => '123456',
        'charset'        => 'utf-8',
        'driver_options' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
        ]
    ]
];
