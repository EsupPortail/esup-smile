<?php

use UnicaenPrivilege\Guard\PrivilegeController;

return array(
    'bjyauthorize'    => [
        'guards' => [
            PrivilegeController::class => [],
        ],
    ],

    'router' => [
        'routes' => [
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
    'controllers' => [
        'factories' => [
        ],
    ],
    'view_helpers' => [
        'invokables' => [
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
);
