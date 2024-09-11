<?php

namespace Application;

use Api\Controller\ApiController;
use Api\Controller\ApiControllerFactory;
use Api\Provider\Privilege\ApiPrivileges;
use UnicaenPrivilege\Guard\PrivilegeController;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

return [
    'bjyauthorize' => [
        'guards' => [
            PrivilegeController::class => [
                [
                    'controller' => ApiController::class,
                    'action' => [
                        ApiController::INDEX_ACTION,
                        ApiController::TEST_ACTION,
                    ],
                ],
            ],
        ],
    ],

    'router'          => [
        'routes' => [
            'api' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/api',
                ],
                'defaults' => [
                    'controller' => ApiController::class,
                    'action' => ApiController::INDEX_ACTION,
                ],
                'child_routes' => [
                    'test' => [
                        'type' => Literal::class,
                        'may_terminate' => true,
                        'options' => [
                            'route'    => '/test',
                            'default' => [
                                'controller' => ApiController::class,
                                'action' => ApiController::TEST_ACTION,
                            ],
                        ]
                    ],
                ],
            ],
        ],
    ],

    'service_manager' => [
        'factories' => [
        ],
    ],
    'controllers'     => [
        'factories' => [
            ApiController::class => ApiControllerFactory::class,
        ],
    ],
    'form_elements' => [
        'factories' => [
        ],
    ],
    'hydrators' => [
        'invokables' => [
        ],
    ],
    'view_helpers' => [
        'invokables' => [
        ],
    ],

];