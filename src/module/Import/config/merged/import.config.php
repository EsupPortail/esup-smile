<?php

namespace Application;

use Import\Controller\ImportController;
use Import\Controller\ImportControllerFactory;
use Import\Service\Import\ImportService;
use Import\Service\Import\ImportServiceFactory;
use Import\View\Helper\ImportViewHelper;
use UnicaenPrivilege\Guard\PrivilegeController;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

return [
    'bjyauthorize' => [
        'guards' => [
            PrivilegeController::class => [
                [
                    'controller' => ImportController::class,
                    'action' => [
                        'index',
                        'download',
                        'delete',
                        'historiser',
                        'restaurer',
                        'delete',
                    ],
                    'roles' => [
                    ],
                ],
            ],
        ],
    ],

    'router'          => [
        'routes' => [

        ],
    ],

    'service_manager' => [
        'factories' => [
            ImportService::class => ImportServiceFactory::class,
        ],
    ],
    'controllers'     => [
        'factories' => [
            ImportController::class => ImportControllerFactory::class,
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
            'import' => ImportViewHelper::class,
        ],
    ],

];