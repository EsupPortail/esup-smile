<?php

/**
 * !! Ce fichier de configuration doit être importé avant les autres
 */

use Application\View\Helper\ShibConnectViewHelper;
use Application\View\Helper\ShibConnectViewHelperFactory;

//define("LDAP_MASTER_HOST", $_ENV['LDAP_MASTER_HOST']);
//define("LDAP_MASTER_PORT", $_ENV['LDAP_MASTER_PORT']);
//define("LDAP_MASTER_USERNAME", $_ENV['LDAP_MASTER_USERNAME']);
//define("LDAP_MASTER_PASSWORD", $_ENV['LDAP_MASTER_PSWD']);
//
//define("LDAP_REPLICA_HOST", $_ENV['LDAP_REPLICA_HOST']);
//define("LDAP_REPLICA_PORT", $_ENV['LDAP_REPLICA_PORT']);
//define("LDAP_REPLICA_USERNAME", $_ENV['LDAP_REPLICA_USERNAME']);
//define("LDAP_REPLICA_PASSWORD", $_ENV['LDAP_REPLICA_PSWD']);
//
//
//const LDAP_BASE_DN = 'dc=unicaen,dc=fr';
//const LDAP_BRANCH_PEOPLE = 'ou=people,dc=unicaen,dc=fr';
//const LDAP_BRANCH_STRUCTURES = 'ou=structures,dc=unicaen,dc=fr';
//const LDAP_BRANCH_GROUPS = 'ou=groups,dc=unicaen,dc=fr';
//const LDAP_BRANCH_DEACTIVATED = 'ou=deactivated,dc=unicaen,dc=fr';
//const LDAP_BRANCH_BLOCKED = 'ou=blocked,dc=unicaen,dc=fr';

define(
    "AUTH_SHIB_ACTIVE",
    !(($_SERVER['SERVER_NAME'] === 'localhost'))
);
const AUTH_LOCAL_ACTIVE = !AUTH_SHIB_ACTIVE;

return [
    // Module [Unicaen]App
    'unicaen-app' => [
        // Connexion LDAP
        'ldap' => [
            'connection' => [
                'default' => [
                    'params' => [
//                        'host' => LDAP_REPLICA_HOST,
//                        'port' => LDAP_REPLICA_PORT,
//                        'username' => LDAP_REPLICA_USERNAME,
//                        'password' => LDAP_REPLICA_PASSWORD,
//                        'baseDn' => LDAP_BRANCH_PEOPLE,
//                        'bindRequiresDn' => true,
//                        'accountFilterFormat' => "(&(objectClass=supannPerson)(supannAliasLogin=%s))",
                    ]
                ]
            ]
        ],
    ],

    // Module [Unicaen]Ldap
//    'unicaen-ldap' => [
//        'host' => LDAP_REPLICA_HOST,
//        'port' => LDAP_REPLICA_PORT,
//        'version' => 3,
//        'username' => LDAP_REPLICA_USERNAME,
//        'password' => LDAP_REPLICA_PASSWORD,
//        'baseDn' => LDAP_BASE_DN,
//        'bindRequiresDn' => true,
//        'accountFilterFormat' => "(&(objectClass=posixAccount)(supannAliasLogin=%s))",
//    ],

    'unicaen-auth' => [
        'auth_types' => [
            'shib',
        ],
        'local' => [
            'order' => 2,

            'enabled' => AUTH_LOCAL_ACTIVE,

            'title' => "Connectez-vous",

            'description' => "",

            /**
             * Mode d'authentification à l'aide d'un compte dans la BDD de l'application.
             */
            'db' => [
                'enabled' => true, // doit être activé pour que l'usurpation fonctionne (cf. Authentication/Storage/Db::read()) :-/
            ],

            /**
             * Mode d'authentification à l'aide d'un compte LDAP.
             */
            'ldap' => [
                'enabled' => false,
            ]
        ],

        /**
         * Configuration de l'authentification Shibboleth.
         */
        'shib' => [
            'order' => 1,
            'enabled' => true,
            'description' =>
                "Cliquez sur le bouton ci-dessous pour accéder à l'authentification via la fédération d'identité.",
            'adapter' => \UnicaenAuthentification\Authentication\Adapter\Shib::class,
            'form' => \UnicaenAuthentification\Form\ShibLoginForm::class,
            'title' => 'Fédération d\'identité',
            /**
             * URL de déconnexion.
             */
            'logout_url' => '/Shibboleth.sso/Logout?return=', // NB: '?return=' semble obligatoire!
            'shib_user_id_extractor' => [
                'default' => [
                    'supannEmpId' => [
                        'name' => 'supannEmpId',
                    ],
                    'supannEtuId' => [
                        'name' => 'supannEtuId',
                    ],
                ],
            ],
        ],

        'cas' => [
            /**
             * Ordre d'affichage du formulaire de connexion.
             */
            'order' => 2,

            /**
             * Activation ou non de ce mode d'authentification.
             */
            'enabled' => false,

            /**
             * Description facultative de ce mode d'authentification qui apparaîtra sur la page de connexion.
             */
            'description' => "Cliquez sur le bouton ci-dessous pour accéder à l'authentification centralisée.",
        ],
        'test' => [
            'order' => '4',
            'enabled' => false,
            'description' => "Authentification de la fédération d'identité"
        ],


        /**
         * Identifiants de connexion LDAP autorisés à faire de l'usurpation d'identité.
         * NB: à réserver exclusivement aux tests.
         */
        'usurpation_allowed_usernames' => [
            'valleet01',
            'gautrea221'
        ],
    ],
];


