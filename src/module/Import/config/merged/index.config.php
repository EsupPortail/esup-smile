<?php

namespace Application;

use Import\Controller\IndexController;
use Import\Controller\IndexControllerFactory;
use Import\Provider\Privilege\ImportPrivileges;
use UnicaenPrivilege\Guard\PrivilegeController;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

return [
    'bjyauthorize' => [
        'guards' => [
            PrivilegeController::class => [
                [
                    'controller' => IndexController::class,
                    'action' => [
                        'index',
                        'import',
                        'parse-catalogue',
                        'smile-connect',
                    ],
                    'privileges' => [
                        ImportPrivileges::IMPORT_INDEX,
                    ],
                ],
            ],
        ],
    ],

    'router'          => [
        'routes' => [
            'import' => [
                'type'          => Literal::class,
                'may_terminate' => true,
                'options' => [
                    'route'    => '/import',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'index',
                    ],
                ],
                'child_routes' => [
                    'index' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/[:type]',
                            'defaults' => [
                                'controller' => IndexController::class,
                                'action'     => 'import',
                            ],
                        ],
                    ],
                    'parseCatalogue' => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/parseCatalogue',
                            'defaults' => [
                                'controller' => IndexController::class,
                                'action'     => 'parse-catalogue',
                            ],
                        ],
                    ],
                    'smileConnect' => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/smileConnect',
                            'defaults' => [
                                'controller' => IndexController::class,
                                'action'     => 'smile-connect',
                            ],
                        ],
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