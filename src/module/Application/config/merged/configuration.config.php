<?php


use Application\Application\View\Helper\Parametre\Factory\ParametreViewHelperFactory;
use Application\Application\View\Helper\Parametre\ParametreViewHelper;
use Application\Controller\Configuration\ConfigurationController;
use Application\Controller\Configuration\Factory\ConfigurationControllerFactory;
use Application\Provider\Privilege\ConfigurationPrivileges;

use Laminas\Router\Http\Literal;
use UnicaenPrivilege\Guard\PrivilegeController;

return [

    'bjyauthorize' => [
        'guards' => [
            PrivilegeController::class => [
                [
                    'controller' => ConfigurationController::class,
                    'action' => [
                        ConfigurationController::ACTION_INDEX,
                        ConfigurationController::ACTION_GET_DATA,
                        ConfigurationController::ACTION_CHANGE_ORDER,
                        ConfigurationController::ACTION_SAVE,
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