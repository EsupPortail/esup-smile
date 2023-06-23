<?php


use Application\Controller\Gestion\GestionController;
use Application\Controller\Gestion\Factory\GestionControllerFactory;
use Application\Provider\Privilege\GestionPrivileges;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use UnicaenPrivilege\Guard\PrivilegeController;

return [

    'bjyauthorize' => [
        'guards' => [
            PrivilegeController::class => [
                [
                    'controller' => GestionController::class,
                    'action' => [
                        GestionController::ACTION_INDEX,
                    ],
                    'privileges' => [
                        GestionPrivileges::GESTION_INDEX,
                    ],
                ],
                [
                    'controller' => GestionController::class,
                    'action' => [
                        GestionController::ACTION_GENERATE,
                    ],
                    'privileges' => [
                        GestionPrivileges::GESTION_GENERATE,
                    ],
                ],
                [
                    'controller' => GestionController::class,
                    'action' => [
                        GestionController::ACTION_VIEW,
                    ],
                    'privileges' => [
                        GestionPrivileges::GESTION_VIEW,
                    ],
                ],
                [
                    'controller' => GestionController::class,
                    'action' => [
                        GestionController::ACTION_VALIDATE,
                        GestionController::ACTION_DENIED,
                    ],
                    'privileges' => [
                        GestionPrivileges::GESTION_VIEW,
                    ],
                ]
            ],
        ],
    ],

    'router' => [
        'routes' => [
            'gestion' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/gestion',
                    'defaults' => [
                        'controller' => GestionController::class,
                        'action' => GestionController::ACTION_INDEX,
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'gestionInscription' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/[:uuid]',
                            'constraints' => [
                                'slug' => '[a-zA-Z0-9_-]+',
                            ],
                            'defaults' => [
                                'controller' => GestionController::class,
                                'action' => GestionController::ACTION_VIEW,
                            ],
                        ]
                    ],
                    'validate' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/validate',
                            'defaults' => [
                                'controller' => GestionController::class,
                                'action' => GestionController::ACTION_VALIDATE
                            ]
                        ]
                    ],
                    'denied' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/denied',
                            'defaults' => [
                                'controller' => GestionController::class,
                                'action' => GestionController::ACTION_DENIED
                            ]
                        ]
                    ],
                    'generate' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/generate',
                            'defaults' => [
                                'controller' => GestionController::class,
                                'action' => GestionController::ACTION_GENERATE
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],

    'controllers' => [
        'factories' => [
            GestionController::class => GestionControllerFactory::class,
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