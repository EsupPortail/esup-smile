<?php

/**
 * UnicaenAuthentification Global Configuration
 */


use Application\Application\View\Helper\ShibConnect\Factory\ShibConnectViewHelperFactory;
use Application\Application\View\Helper\ShibConnect\ShibConnectViewHelper;
use UnicaenAuthentification\Form\LoginForm;

return [
    'unicaen-auth' =>  [
        /**
         * Flag indiquant si l'utilisateur authenitifié avec succès via l'annuaire LDAP doit
         * être enregistré/mis à jour dans la table des utilisateurs de l'appli.
         */
//        'save_ldap_user_in_database' => true,

        'entity_manager_name' => 'doctrine.entitymanager.orm_default', // nom du gestionnaire d'entités à utiliser

        /**
         * Attribut LDAP utilisé pour le username des utilisateurs
         * A personnaliser au besoin
         */
        //'ldap_username' => 'supannaliaslogin',


        'auth_types' => [
            'local', // càd 'ldap' et 'db'
            'shib',
            'test',
        ],
        'test' => [
            'enabled' => false,
            'form' => LoginForm::class,
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'testConnect' => ShibConnectViewHelper::class,
            'shibConnect' => ShibConnectViewHelper::class
        ],
        'factories' => [
            ShibConnectViewHelper::class => ShibConnectViewHelperFactory::class
        ]
    ],
];


