
<?php

/**
 * !! Ce fichier de configuration doit être importé avant les autres
 */

$WAYF_SP_URL = $_ENV['WAYF_SP_URL'];

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
                   ]
                ]
            ],
        ],
    ],
    'unicaen-auth' => [
        'auth_types' => [
            'shib',
        ],
        'local' => [
            'order' => 2,

            'enabled' => true,

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
                'username' => 'supannAliasLogin',
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
            'logout_url' => $WAYF_SP_URL.'Shibboleth.sso/Logout?return=', // NB: '?return=' semble obligatoire!
            'idp_logout' => true,
//            'aliases' => [
//                'displayName'            => 'HTTP_DISPLAYNAME',
//                'eduPersonPrincipalName' => 'HTTP_EPPN',
//                'eppn'                   => 'eppn',
//                'eduOrgLegalName' => 'HTTP_ORG_NAME',
//                'mail'                   => 'HTTP_MAIL',
//                'o' => 'HTTP_O',
//                'shacDateOfBirth' => 'HTTP_BIRTHDATE',
//                'givenName'              => 'HTTP_GIVENNAME',
//                'sn'                     => 'HTTP_SN',
//                'homePostalAddress'            => 'HTTP_POSTALADDRESS',
//                'shacHomeOrganization'            => 'HTTP_SHACORG',
//            ],
            /**
             * Clés dont la présence sera requise par l'application dans la variable superglobale $_SERVER
             * une fois l'authentification réussie.
             */
            'required_attributes' => [
                'displayName',
                'eppn',
//                'eduPersonPrincipalName',
//                'eduOrgLegalName',
                'mail',
//                'o',
//                'shacDateOfBirth',
//                'gn|givenName',
//                'sn|surname', // i.e. 'sn' ou 'surname'
//                'homePostalAddress',
//                'shacHomeOrganization',
            ],

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
            /**
             * Identifiants de connexion autorisés à faire de l'usurpation d'identité.
             * (NB: à réserver exclusivement aux tests.)
             */
            //'usurpation_allowed_usernames' => [
                //'username', // format LDAP
                //'e.mail@domain.fr', // format BDD
                //'eppn@domain.fr', // format Shibboleth
            //],
//            'simulate' => [
//                'eppn'           => $eppn = 'premierf@univ.fr',
//                'supannEmpId'    => '00012345',
//                'displayName'    => $eppn,
//                'mail'           => $eppn,
//                'givenName'      => 'François',
//                'sn'             => 'Premier',
//                'supannCivilite' => 'M.'
//            ],

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
            'description' => "Authentification de la fédération d'identité",
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

