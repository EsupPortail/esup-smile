<?php

namespace Application;

use Message\Controller\MessageController;
use Message\Controller\MessageControllerFactory;
use Message\Service\Message\MessageService;
use Message\Service\Message\MessageServiceFactory;
use Message\View\Helper\MessageViewHelper;
use UnicaenPrivilege\Guard\PrivilegeController;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

return [
    'bjyauthorize' => [
        'guards' => [
            PrivilegeController::class => [
                [
                    'controller' => MessageController::class,
                    'action' => [
                        MessageController::ADD_MESSAGE_ACTION,
                    ],
                    'roles' => [

                    ],
                ],
            ],
        ],
    ],

    'router'          => [
        'routes' => [
            'fichier' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/message',
                ],
                'child_routes' => [
                    'message' => [
                        'type' => Literal::class,
                        'options' => [
                            'route'    => '/addMessage',
                            'defaults' => [
                                'controller' => MessageController::class,
                                'action' => MessageController::ADD_MESSAGE_ACTION,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'service_manager' => [
        'factories' => [
            MessageService::class => MessageServiceFactory::class
        ],
    ],
    'controllers'     => [
        'factories' => [
            MessageController::class => MessageControllerFactory::class,
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
            'fichier' => MessageViewHelper::class,
        ],
    ],

];