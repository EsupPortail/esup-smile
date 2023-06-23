<?php

/**
 * !! Adaptater vers pick your cources
 */


use Doctrine\DBAL\Driver\PDO\PgSQL\Driver;
$settings = [
    'doctrine' => [
        'connection' => [
            'orm_pyc' => [
                'driverClass' => Driver::class,
                'params' => [
                    'host'          => $_ENV['DB_PYC_HOST'],
                    'port'          => $_ENV['DB_PYC_PORT'],
                    'dbname'        => $_ENV['DB_PYC_NAME'],
                    'user'          => $_ENV['DB_PYC_USER'],
                    'password'      => $_ENV['DB_PYC_PSWD'],
                    'charset'       => 'utf8',
                    'driverOptions' => [1002 => 'SET NAMES utf8']
                ],
            ],
        ],
        'entitymanager' => [
            'orm_pyc' => [
                'connection' => 'orm_pyc',
                'configuration' => 'orm_pyc',
            ],
        ],
        'configuration' => [
            'orm_pyc' => [
                'metadata_cache' => 'array',
                'query_cache' => 'array',
                'result_cache' => 'array',
                'hydration_cache' => 'array',
                'generate_proxies' => true,
            ],
        ],
    ],
];

return $settings;

