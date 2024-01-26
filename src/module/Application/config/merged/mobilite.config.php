<?php


use Application\Controller\Dashboard\DashboardController;
use Application\Controller\Dashboard\Factory\DashboardControllerFactory;
use Application\Controller\Mobilite\Factory\MobiliteControllerFactory;
use Application\Controller\Mobilite\MobiliteController;
use Application\Provider\Privilege\DashboardPrivileges;

use Application\Provider\Privilege\MobilitePrivileges;
use Application\Service\Dashboard\DashboardService;
use Application\Service\Dashboard\DashboardServiceFactory;
use Application\Service\Mobilite\MobiliteService;
use Application\Service\Mobilite\MobiliteServiceFactory;
use Application\Service\Step\StepMessageService;
use Application\Service\Step\StepMessageServiceFactory;
use Application\Service\Step\StepService;
use Application\Service\Step\StepServiceFactory;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use UnicaenPrivilege\Guard\PrivilegeController;

return [

    'bjyauthorize' => [
        'guards' => [
            PrivilegeController::class => [
                [
                    'controller' => MobiliteController::class,
                    'action' => [
                        MobiliteController::ACTION_INDEX,
                        MobiliteController::ACTION_ADD,
                        MobiliteController::ACTION_ADD_TYPE_DOCUMENT,
                        MobiliteController::ACTION_REMOVE_TYPE_DOCUMENT,
                        MobiliteController::ACTION_DELETE,
                        MobiliteController::ACTION_ACTIVE,
                        MobiliteController::ACTION_UPDATE,
                        MobiliteController::ACTION_SHOW,
                    ],
                    'privileges' => [
                        MobilitePrivileges::MOBILITE_INDEX
                    ],
                ]
            ],
        ],
    ],

    'router' => [
        'routes' => [
            'mobilite' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/mobilite',
                    'defaults' => [
                        'controller' => MobiliteController::class,
                        'action' => MobiliteController::ACTION_INDEX,
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'show' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '[/:id]',
                            'defaults' => [
                                'controller' => MobiliteController::class,
                                'action' => MobiliteController::ACTION_SHOW
                            ]
                        ]
                    ],
                    'add' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/addMobilite',
                            'defaults' => [
                                'controller' => MobiliteController::class,
                                'action' => MobiliteController::ACTION_ADD
                            ]
                        ]
                    ],
                    'addTypeDocument' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/addTypeDocument',
                            'defaults' => [
                                'controller' => MobiliteController::class,
                                'action' => MobiliteController::ACTION_ADD_TYPE_DOCUMENT
                            ]
                        ]
                    ],
                    'removeTypeDocument' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/removeTypeDocument',
                            'defaults' => [
                                'controller' => MobiliteController::class,
                                'action' => MobiliteController::ACTION_REMOVE_TYPE_DOCUMENT
                            ]
                        ]
                    ],
                    'update' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/updateMobilite',
                            'defaults' => [
                                'controller' => MobiliteController::class,
                                'action' => MobiliteController::ACTION_UPDATE
                            ]
                        ]
                    ],
                    'delete' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/deleteMobilite[/:id]',
                            'defaults' => [
                                'controller' => MobiliteController::class,
                                'action' => MobiliteController::ACTION_DELETE
                            ]
                        ]
                    ],
                    'active' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/activeMobilite',
                            'defaults' => [
                                'controller' => MobiliteController::class,
                                'action' => MobiliteController::ACTION_ACTIVE
                            ]
                        ]
                    ],
                ]
            ]
        ]
    ],

    'controllers' => [
        'factories' => [
            MobiliteController::class => MobiliteControllerFactory::class,
        ],
    ],

    'service_manager' => [
        'factories' => [
            MobiliteService::class => MobiliteServiceFactory::class,
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