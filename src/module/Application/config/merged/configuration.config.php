<?php


use Application\Application\View\Helper\Parametre\Factory\ParametreViewHelperFactory;
use Application\Application\View\Helper\Parametre\ParametreViewHelper;
use Application\Controller\Configuration\ConfigurationController;
use Application\Controller\Configuration\Factory\ConfigurationControllerFactory;
use Application\Provider\Privilege\ConfigurationPrivileges;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use UnicaenPrivilege\Guard\PrivilegeController;

return [

    'bjyauthorize' => [
        'guards' => [
            PrivilegeController::class => [
                [
                    'controller' => ConfigurationController::class,
                    'action' => [
                        ConfigurationController::ACTION_INDEX,
                        ConfigurationController::ACTION_CALENDAR,
                        ConfigurationController::ACTION_GET_DATA,
                        ConfigurationController::ACTION_CHANGE_ORDER,
                        ConfigurationController::ACTION_SAVE,
                        ConfigurationController::ACTION_DELETE,
                        ConfigurationController::ACTION_ADD,
                        ConfigurationController::ACTION_GESTIONNAIRE_COMPOSANTE,
                        ConfigurationController::ACTION_ADD_ATTRIBUTION,
                        ConfigurationController::ACTION_REMOVE_ATTRIBUTION,
                        ConfigurationController::ACTION_ADD_COMPOSANTE_TO_GROUP,
                        ConfigurationController::ACTION_REMOVE_COMPOSANTE_TO_GROUP,
                        ConfigurationController::ACTION_ADD_GROUP,
                        ConfigurationController::ACTION_DELETE_GROUP,
                        ConfigurationController::ACTION_GET_DATA_COMPOSANTE_GROUP,
                    ],
                    'privileges' => [
                        ConfigurationPrivileges::CONFIGURATION_INDEX,
                    ],
                ]
            ],
        ],
    ],

    'router' => [
        'routes' => [
            'Configuration' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/configuration',
                    'defaults' => [
                        'controller' => ConfigurationController::class,
                        'action' => ConfigurationController::ACTION_INDEX,
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'getData' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/getData',
                            'defaults' => [
                                'controller' => ConfigurationController::class,
                                'action' => ConfigurationController::ACTION_GET_DATA
                            ]
                        ]
                    ],
                    'changeOrder' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/changeOrder',
                            'defaults' => [
                                'controller' => ConfigurationController::class,
                                'action' => ConfigurationController::ACTION_CHANGE_ORDER
                            ]
                        ]
                    ],
                    'save' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/save',
                            'defaults' => [
                                'controller' => ConfigurationController::class,
                                'action' => ConfigurationController::ACTION_SAVE
                            ]
                        ]
                    ],
                    'delete' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/delete',
                            'defaults' => [
                                'controller' => ConfigurationController::class,
                                'action' => ConfigurationController::ACTION_DELETE
                            ]
                        ]
                    ],
                    'add' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/add',
                            'defaults' => [
                                'controller' => ConfigurationController::class,
                                'action' => ConfigurationController::ACTION_ADD
                            ]
                        ]
                    ],
                    'addAttribution' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/addAttribution',
                            'defaults' => [
                                'controller' => ConfigurationController::class,
                                'action' => ConfigurationController::ACTION_ADD_ATTRIBUTION
                            ]
                        ]
                    ],
                    'removeAttribution' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/removeAttribution',
                            'defaults' => [
                                'controller' => ConfigurationController::class,
                                'action' => ConfigurationController::ACTION_REMOVE_ATTRIBUTION
                            ]
                        ]
                    ],
                    'addGroup' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/addGroup',
                            'defaults' => [
                                'controller' => ConfigurationController::class,
                                'action' => ConfigurationController::ACTION_ADD_GROUP
                            ]
                        ]
                    ],
                    'deleteGroup' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/deleteGroup[/:id]',
                            'defaults' => [
                                'controller' => ConfigurationController::class,
                                'action' => ConfigurationController::ACTION_DELETE_GROUP
                            ]
                        ]
                    ],
                    'addComposanteToGroup' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/addComposanteToGroup',
                            'defaults' => [
                                'controller' => ConfigurationController::class,
                                'action' => ConfigurationController::ACTION_ADD_COMPOSANTE_TO_GROUP
                            ]
                        ]
                    ],
                    'removeComposanteToGroup' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/removeComposanteToGroup',
                            'defaults' => [
                                'controller' => ConfigurationController::class,
                                'action' => ConfigurationController::ACTION_REMOVE_COMPOSANTE_TO_GROUP
                            ]
                        ]
                    ],
                    'getDataComposanteGroup' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/getDataComposanteGroup',
                            'defaults' => [
                                'controller' => ConfigurationController::class,
                                'action' => ConfigurationController::ACTION_GET_DATA_COMPOSANTE_GROUP
                            ]
                        ]
                    ],
                    'gestionnairecomposante' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/gestionnaire-composante',
                            'defaults' => [
                                'controller' => ConfigurationController::class,
                                'action' => ConfigurationController::ACTION_GESTIONNAIRE_COMPOSANTE
                            ]
                        ]
                    ],
                    'calendar' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/calendar',
                            'defaults' => [
                                'controller' => ConfigurationController::class,
                                'action' => ConfigurationController::ACTION_CALENDAR
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],

    'controllers' => [
        'factories' => [
            ConfigurationController::class => ConfigurationControllerFactory::class,
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
            'parametre' => ParametreViewHelper::class,
        ],
        'factories' => [
            ParametreViewHelper::class => ParametreViewHelperFactory::class,
        ]
    ],
];