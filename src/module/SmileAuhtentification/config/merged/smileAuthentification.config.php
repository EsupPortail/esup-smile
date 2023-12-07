<?php

namespace SmileAuthentification;

use Fichier\Controller\ImportController;
use Fichier\Service\Fichier\FichierService;
use SmileAuthentification\Controller\SmileAuthentificationController;
use SmileAuthentification\Controller\SmileAuthentificationControllerFactory;
use SmileAuthentification\Service\SmileAuthentification\SmileAuthentificationService;
use SmileAuthentification\Service\SmileAuthentification\SmileAuthentificationServiceFactory;
use UnicaenPrivilege\Guard\PrivilegeController;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

return [
    'bjyauthorize' => [
        'guards' => [
        ],
    ],

    'router'          => [
        'routes' => [

        ],
    ],

    'service_manager' => [
        'factories' => [
            SmileAuthentificationService::class => SmileAuthentificationServiceFactory::class,
        ],
    ],
    'controllers'     => [
        'factories' => [
            SmileAuthentificationController::class => SmileAuthentificationControllerFactory::class,
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