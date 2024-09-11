<?php

namespace Message;

use \Application\Provider\Privilege\DashboardPrivileges;
use Message\Controller\IndexController;
use Message\Controller\IndexControllerFactory;
use Message\Provider\Privilege\MessagePrivileges;
use UnicaenPrivilege\Guard\PrivilegeController;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

return [
    'bjyauthorize' => [
        'guards' => [
            PrivilegeController::class => [],
        ],
    ],

    'router'          => [
        'routes' => [
            'index-fichier' => [
                'type'          => Literal::class,
                'may_terminate' => true,
                'options' => [
                    'route'    => '/index-message',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],

        ],
    ],

    'service_manager' => [
        'factories' => [],
    ],
    'controllers'     => [
        'factories' => [
            IndexController::class => IndexControllerFactory::class,
        ],
    ],
    'form_elements' => [
        'factories' => [],
    ],
    'hydrators' => [
        'factories' => [],
    ]

];