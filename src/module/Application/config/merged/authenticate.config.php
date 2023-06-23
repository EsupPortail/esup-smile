<?php


use Application\Controller\Authenticate\AuthenticateController;
use Application\Controller\Authenticate\Factory\AuthenticateControllerFactory;
use Application\Provider\Privilege\AuthenticatePrivileges;
use Application\Provider\Privilege\DashboardPrivileges;
use Laminas\Router\Http\Literal;
use UnicaenPrivilege\Guard\PrivilegeController;

return [

    'bjyauthorize' => [
        'guards' => [
            PrivilegeController::class => [
                [
                    'controller' => AuthenticateController::class,
                    'action' => [
                        AuthenticateController::ACTION_INDEX,
                    ],
                    'privileges' => [
                        AuthenticatePrivileges::AUTHENTICATE_INDEX,
                    ],
                ],
            ],
        ],
    ],

    'router' => [
        'routes' => [
            'authenticate' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/authenticate',
                    'defaults' => [
                        'controller' => AuthenticateController::class,
                        'action' => AuthenticateController::ACTION_INDEX,
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [

                ]
            ]
        ]
    ],

    'controllers' => [
        'factories' => [
            AuthenticateController::class => AuthenticateControllerFactory::class,
        ],
    ],

    'service_manager' => [
        'factories' => [
        ],
    ],

    'form_elements' => [
        'factories' => [
        ],
    ],

    'view_helpers' => [
        'aliases' => [
        ],
        'factories' => [
        ]
    ],
];