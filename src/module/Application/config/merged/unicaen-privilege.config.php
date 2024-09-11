<?php
/**
 * Fichier de configurations vide pour avoir les clés de base
 * Basé sur UnicaenUtilisateur/UnicaenPrivileges
 */

use Laminas\Router\Http\Literal;
use UnicaenPrivilege\Guard\PrivilegeController;
use UnicaenPrivilege\Provider\Privilege\PrivilegePrivileges;
use UnicaenUtilisateur\Controller\UtilisateurController;
use UnicaenUtilisateur\Provider\Privilege\RolePrivileges;
use UnicaenUtilisateur\Provider\Privilege\UtilisateurPrivileges;

return [
    /** Priviléges pour les actions */
    'bjyauthorize' => [
        'guards' => [
            PrivilegeController::class => [
            ],
        ],

        //Definition des ressources utilisées pour les assertions
        'resource_providers' => [
            'BjyAuthorize\Provider\Resource\Config' => [
            ],
        ],
        //Configurations des assertions sur les entités (implique de surcharger derriére la fonction assertEntity
        'rule_providers' => [
            'UnicaenPrivilege\Provider\Rule\PrivilegeRuleProvider' => [
                'allow' => [
                ],
            ],
        ],
    ],

    /** Routes pour les actions */
    'router' => [
        'routes' => [
            'administration' => [ //Ajoute les pages liée a UnicaenUtilisateur, UnicaenPriviléges ...
                'type' => Literal::class,
                'options' => [
                    'route' => '/administration',
                    'defaults' => [
                        'controller' => UtilisateurController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],

    /** Controlleurs */
    'controllers' => [
        'factories' => [
        ],
    ],

    /** Services */
    'service_manager' => [
        'factories' => [
        ],
    ],

    /** Formulaires */
    'form_elements' => [
        'invokables' => [
        ],
        'factories' => [
        ],
    ],

    /** Hydrator */
    'hydrators' => [
        'factories' => [
        ],
    ],

    /** Validateur */
    'validators' => [
        'factories' => [
        ],
    ],

    /** ViewHelper */
    'view_helpers' => [
        'aliases' => [
        ],
        'factory' => [
        ]
    ],

//    /** Navigation */
    'navigation' => [
        'default' => [
            'home' => [
                'pages' => [

                ],
            ],
        ],
    ],
];
?>