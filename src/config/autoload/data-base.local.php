<?php

use Doctrine\DBAL\Driver\PDO\PgSQL\Driver;

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => Driver::class,
                'params' => [
//                    //Versions BD Local
                    'host' => $_ENV['DB_HOST'],
                    'dbname' => $_ENV['DB_NAME'],
                    'port' => $_ENV['DB_PORT'],
                    'charset' => 'utf8',
                    'user' => $_ENV['DB_USER'],     // cf. docker-compose.yml
                    'password' => $_ENV['DB_PSWD'],
                ],
            ],
        ],
    ],
];