<?php


use Application\Controller\Dashboard\DashboardController;
use Application\Controller\Dashboard\Factory\DashboardControllerFactory;
use Application\Provider\Privilege\DashboardPrivileges;

use Application\Service\Dashboard\DashboardService;
use Application\Service\Dashboard\DashboardServiceFactory;
use Application\Service\Document\DocumentService;
use Application\Service\Document\DocumentServiceFactory;
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
                    'controller' => DashboardController::class,
                    'action' => [
                        DashboardController::ACTION_INDEX,
                        DashboardController::ACTION_SAVECOURSES,
                        DashboardController::ACTION_GENERATE_PDF,
                        DashboardController::ACTION_ABANDON,
                    ],
                    'privileges' => [
                        DashboardPrivileges::DASHBOARD_INDEX
                    ],
                ],
                [
                    'controller' => DashboardController::class,
                    'action' => [
                        DashboardController::ACTION_COURSES,
                        DashboardController::ACTION_VALIDATEOLA,
                        DashboardController::ACTION_UPLOAD_FICHIER,
                        DashboardController::ACTION_REMOVE_DOCUMENT,
                        DashboardController::ACTION_VALIDATECOURSES,
                        DashboardController::ACTION_COURSES_VIEW,
                    ],
                    'privileges' => [
                        DashboardPrivileges::DASHBOARD_COURSES
                    ]
                ]
            ],
        ],
    ],

    'router' => [
        'routes' => [
            'dashboard' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/dashboard',
                    'defaults' => [
                        'controller' => DashboardController::class,
                        'action' => DashboardController::ACTION_INDEX,
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'courses' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/courses',
                            'defaults' => [
                                'controller' => DashboardController::class,
                                'action' => DashboardController::ACTION_COURSES
                            ]
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'coursDescriptif' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/[:uuid]',
                                    'constraints' => [
                                        'slug' => '[a-zA-Z0-9_-]+',
                                    ],
                                    'defaults' => [
                                        'controller' => DashboardController::class,
                                        'action' => DashboardController::ACTION_COURSES_VIEW,
                                    ],
                                ]
                            ],
                        ],
                    ],
                    'saveCourses' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/saveCourses',
                            'defaults' => [
                                'controller' => DashboardController::class,
                                'action' => DashboardController::ACTION_SAVECOURSES
                            ]
                        ]
                    ],
                    'validateCourses' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/validateCourses',
                            'defaults' => [
                                'controller' => DashboardController::class,
                                'action' => DashboardController::ACTION_VALIDATECOURSES
                            ]
                        ]
                    ],
                    'abandon' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/abandon',
                            'defaults' => [
                                'controller' => DashboardController::class,
                                'action' => DashboardController::ACTION_ABANDON
                            ]
                        ]
                    ],
                    'validateOla' => [
                        'type' => Literal::class,
                        'options' => [
                            /**
                             * @see DashboardController::validateOlaAction()
                             */
                            'route' => '/validateOla',
                            'defaults' => [
                                'controller' => DashboardController::class,
                                'action' => DashboardController::ACTION_VALIDATEOLA
                            ]
                        ]
                    ],
                    'generatePdf' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/generatePdf',
                            'defaults' => [
                                'controller' => DashboardController::class,
                                'action' => DashboardController::ACTION_GENERATE_PDF
                            ]
                        ]
                    ],
                    'uploadFichier' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/uploadFichier',
                            'defaults' => [
                                'controller' => DashboardController::class,
                                'action' => DashboardController::ACTION_UPLOAD_FICHIER
                            ]
                        ]
                    ],
                    'removeDocument' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/removeDocument',

                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'removeDocumentFile' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/[:fileName]',
                                    'defaults' => [
                                        'controller' => DashboardController::class,
                                        'action' => DashboardController::ACTION_REMOVE_DOCUMENT,
                                    ],
                                ]
                            ],
                        ],
                    ]
                ]
            ]
        ]
    ],

    'controllers' => [
        'factories' => [
            DashboardController::class => DashboardControllerFactory::class,
        ],
    ],

    'service_manager' => [
        'factories' => [
            DashboardService::class   => DashboardServiceFactory::class,
            StepService::class        => StepServiceFactory::class,
            StepMessageService::class => StepMessageServiceFactory::class,
            DocumentService::class    => DocumentServiceFactory::class,
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