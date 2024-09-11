<?php


use Application\Application\Form\Inscription\EtablissementFieldset;
use Application\Application\Form\Inscription\Factory\EtablissementFieldsetFactory;
use Application\Application\Form\Inscription\Factory\InscriptionFieldsetFactory;
use Application\Application\Form\Inscription\Factory\InscriptionFormFactory;
use Application\Application\Form\Inscription\Factory\InscriptionHydratorFactory;
use Application\Application\Form\Inscription\Factory\InscriptionUserFormFactory;
use Application\Application\Form\Inscription\InscriptionFieldset;
use Application\Application\Form\Inscription\InscriptionForm;
use Application\Application\Form\Inscription\InscriptionUserFieldset;
use Application\Application\Form\Inscription\InscriptionUserForm;
use Application\Application\Form\InscriptionUser\Factory\InscriptionUserFieldsetFactory;
use Application\Controller\Inscription\Factory\InscriptionControllerFactory;
use Application\Controller\Inscription\InscriptionController;
use Application\Form\Inscription\InscriptionHydrator;
use Application\Service\Etablissement\EtablissementService;
use Application\Service\Etablissement\EtablissementServiceFactory;
use Application\Service\Inscription\InscriptionService;
use Application\Service\Inscription\InscriptionServiceFactory;
use Application\Provider\Privilege\InscriptionPrivileges;

use Application\Service\Pays\PaysService;
use Application\Service\Pays\PaysServiceFactory;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use UnicaenPrivilege\Guard\PrivilegeController;

return [

    'bjyauthorize' => [
        'guards' => [
            PrivilegeController::class => [
                [
                    'controller' => InscriptionController::class,
                    'action' => [
                        InscriptionController::ACTION_INDEX,
                        InscriptionController::ACTION_MOBILITE,
                        InscriptionController::ACTION_INFORMATION,
                        InscriptionController::ACTION_INFORMATION_VUE,
                        InscriptionController::ACTION_ETABLISSEMENT,
                        InscriptionController::ACTION_MOBILITES,
                    ],
                    'privileges' => [
                        InscriptionPrivileges::INSCRIPTION_INDEX
                    ],
                ],
            ],
        ],
    ],

    'router' => [
        'routes' => [
            'inscription' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/inscription',
                    'defaults' => [
                        'controller' => InscriptionController::class,
                        'action' => InscriptionController::ACTION_INDEX,
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'mobilite' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/mobilite[/:typeMobilite]',
                            'defaults' => [
                                'controller' => InscriptionController::class,
                                'action' => InscriptionController::ACTION_MOBILITE
                            ]
                        ]
                    ],
                    'information' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/information',
                            'defaults' => [
                                'controller' => InscriptionController::class,
                                'action' => InscriptionController::ACTION_INFORMATION
                            ]
                        ]
                    ],
                    'informationVue' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/informationVue',
                            'defaults' => [
                                'controller' => InscriptionController::class,
                                'action' => InscriptionController::ACTION_INFORMATION_VUE
                            ]
                        ]
                    ],
                    'etablissements' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/etablissements',
                            'defaults' => [
                                'controller' => InscriptionController::class,
                                'action' => InscriptionController::ACTION_ETABLISSEMENT
                            ]
                        ]
                    ],
                    'mobilites' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/mobilites',
                            'defaults' => [
                                'controller' => InscriptionController::class,
                                'action' => InscriptionController::ACTION_MOBILITES
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],

    'controllers' => [
        'factories' => [
            InscriptionController::class => InscriptionControllerFactory::class,
        ],
    ],

    'service_manager' => [
        'factories' => [
            InscriptionService::class => InscriptionServiceFactory::class,
            EtablissementService::class => EtablissementServiceFactory::class,
            PaysService::class => PaysServiceFactory::class,
        ],
    ],

    'form_elements' => [
        'factories' => [
            InscriptionForm::class => InscriptionFormFactory::class,
            InscriptionFieldset::class =>InscriptionFieldsetFactory::class,
            InscriptionUserForm::class =>InscriptionUserFormFactory::class,
            InscriptionUserFieldset::class =>InscriptionUserFieldsetFactory::class,
            EtablissementFieldset::class =>EtablissementFieldsetFactory::class,
        ],
    ],

//    'hydrators' => [
//        'invokables' => [
//        ],
//        'factories' => [
//            InscriptionHydrator::class => InscriptionHydratorFactory::class
//        ],
//    ],


    'view_helpers' => [
        'aliases' => [
        ],
        'factories' => [
        ]
    ],

    'navigation' => [
        'default' => [
            'home' => [
                'pages' => [

                ],
            ],
        ],
    ],
];