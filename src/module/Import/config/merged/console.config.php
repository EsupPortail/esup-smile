<?php
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'console' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => 'bonjour',
                    'defaults' => [
                        'controller' => \Import\Controller\ConsoleController::class,
                        'action'     => 'bonjour',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            'Import\Controller\Console' => InvokableFactory::class,
        ],
    ],
];