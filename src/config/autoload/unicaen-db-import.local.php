<?php
/**
 * Exemple de configuration locale du module unicaen/db-import.
 */

namespace Application;

use Doctrine\DBAL\Driver\PDO\PgSQL\Driver;

return [
    'import' => [
        'connections' => [
            //
            // Bases de données.
            // Format: 'identifiant unique' => 'nom de la connexion Doctrine'
            //
            'orm_default' => 'doctrine.connection.orm_default',
            'orm_pyc' => 'doctrine.connection.orm_pyc',
//            //
//            // API.
//            // Format: 'identifiant unique' => tableau de config Guzzle
//            //
//            'geo' => [
//                'url'      => 'https://geo.api.gouv.fr',
//                'proxy'    => false,
//                'verify'   => true,
//                'user'     => null,
//                'password' => null,
//
//                // Implémentés, mais pas gérés par Guzzle :
//                // - 'page_param'      : nom du paramètre à utiliser pour demander une page de données précise
//                // - 'page_size_param' : nom du paramètre à utiliser pour demander une taille de page précise
//                /*
//                'page_param'      => 'page',
//                'page_size_param' => 'page_size',
//                */
//            ],
        ],
    ],
//
//    /**
//     * Configuration de Doctrine
//     */
    'doctrine' => [
        'connection' => [
            'orm_pyc' => [
                'driverClass' => Driver::class,
                'params' => [
                    'host'          => getenv('DB_PYC_HOST'),
                    'port'          => getenv('DB_PYC_PORT'),
                    //Base prod' user admin
                    'dbname'        => getenv('DB_PYC_NAME'),
                    'user'          => getenv('DB_PYC_USER'),
                    'password'      => getenv('DB_PYC_PSWD'),
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

    'navigation' => [
        'default' => [
            'home' => [
                'pages' => [
                    'unicaen-db-import' => [
//                        'label' => "Import/Synchro",
//                        'route' => 'unicaen-db-import/import',
//                        'resource' => ImportPrivilege::getResourceId(ImportPrivilege::LISTER),
//                        'order' => 100,
                        'visible' => false,
                    ],
                ]
            ]
        ]
    ]
];
