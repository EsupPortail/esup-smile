<?php
/**
 * Fichier de configurations vide pour avoir les clés de base
 * Basé sur UnicaenUtilisateur/UnicaenPrivileges
 */

use Application\Application\Form\Composante\ComposanteFieldset;
use Application\Application\Form\Composante\ComposanteForm;
use Application\Application\Form\Composante\ComposanteHydrator;
use Application\Application\Form\Composante\Factory\ComposanteFieldsetFactory;
use Application\Application\Form\Composante\Factory\ComposanteFormFactory;
use Application\Application\Service\Composante\ComposanteService;
use Application\Application\Service\Composante\ComposanteServiceFactory;
use Application\Application\Validator\Actions\ComposanteActionsValidator;
use Application\Application\Validator\Actions\Factory\AbstractActionsValidatorFactory;
use Application\Application\View\Helper\Composante\ComposanteViewHelper;
use Application\Application\View\Helper\Composante\ComposanteViewHelperFactory;
use Application\Controller\Composante\ComposanteController;
use Application\Controller\Composante\Factory\ComposanteControllerFactory;
use Application\Provider\Privilege\SmilePrivileges;
use Application\Provider\Privilege\FormationPrivileges;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use UnicaenPrivilege\Guard\PrivilegeController;

return [
    /** Priviléges pour les actions */
    'bjyauthorize' => [
        'guards' => [
            PrivilegeController::class => [
                [
                    'controller' => ComposanteController::class,
                    'action' => [
                        ComposanteController::ACTION_INDEX,
                        ComposanteController::ACTION_LISTER,
                        ComposanteController::ACTION_AFFICHER,
                        ComposanteController::ACTION_GET_ACTIONS_MENU
                    ],
                    'privileges' => [
                        FormationPrivileges::COMPOSANTE_AFFICHER,
                    ],
                ],
                [
                    'controller' => ComposanteController::class,
                    'action' => [
                        ComposanteController::ACTION_AJOUTER,
                    ],
                    'privileges' => [
                        FormationPrivileges::COMPOSANTE_AJOUTER
                    ],
                ],
                [
                    'controller' => ComposanteController::class,
                    'action' => [
                        ComposanteController::ACTION_MODIFIER,
                        ComposanteController::ACTION_ARCHIVER,
                        ComposanteController::ACTION_RESTAURER,
                    ],
                    'privileges' => [
                        FormationPrivileges::COMPOSANTE_MODIFIER
                    ],
                ],
                [
                    'controller' => ComposanteController::class,
                    'action' => [
                        ComposanteController::ACTION_SUPPRIMER,
                    ],
                    'privileges' => [
                        FormationPrivileges::COMPOSANTE_SUPPRIMER
                    ],
                ],
            ],
        ],

        //Definition des ressources utilisées pour les assertions
        'resource_providers' => [
            'BjyAuthorize\Provider\Resource\Config' => [
            ],
        ],
        //Configurations des assertions sur les entités (implique de surcharger derriére la fonction assertEntity
        'rule_providers' => [
            'UnicaenPrivilege\Provider\Rule\PrivilegeRuleProvider' => [
                'allow' => [
                ],
            ],
        ],
    ],

    /** Routes pour les actions */
    'router' => [
        'routes' => [
            'composantes' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/composantes',
                    'defaults' => [
                        'controller' => ComposanteController::class,
                        'action' => ComposanteController::ACTION_INDEX,
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'lister' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/lister',
                            'defaults' => [
                                'controller' => ComposanteController::class,
                                'action' => ComposanteController::ACTION_LISTER,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                ],
            ],
            'composante' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/composante',
                ],
                'may_terminate' => false,
                'child_routes' => [
                    'afficher' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/afficher/:composante',
                            'constraints' => [
                                'composante' => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => ComposanteController::class,
                                'action' => ComposanteController::ACTION_AFFICHER,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'ajouter' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/ajouter',
                            'defaults' => [
                                'controller' => ComposanteController::class,
                                'action' => ComposanteController::ACTION_AJOUTER,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'modifier' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/modifier/:composante',
                            'constraints' => [
                                'composante' => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => ComposanteController::class,
                                'action' => ComposanteController::ACTION_MODIFIER,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'archiver' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/archiver/:composante',
                            'constraints' => [
                                'composante' => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => ComposanteController::class,
                                'action' => ComposanteController::ACTION_ARCHIVER,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'restaurer' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/restaurer/:composante',
                            'constraints' => [
                                'composante' => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => ComposanteController::class,
                                'action' => ComposanteController::ACTION_RESTAURER,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'supprimer' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/supprimer/:composante',
                            'constraints' => [
                                'composante' => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => ComposanteController::class,
                                'action' => ComposanteController::ACTION_SUPPRIMER,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'actions' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/actions/:composante',
                            'constraints' => [
                                'composante' => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => ComposanteController::class,
                                'action' => ComposanteController::ACTION_GET_ACTIONS_MENU,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
               ],
            ],
        ],
    ],

    /** Controlleurs */
    'controllers' => [
        'factories' => [
            ComposanteController::class => ComposanteControllerFactory::class
        ],
    ],

    /** Services */
    'service_manager' => [
        'factories' => [
            ComposanteService::class => ComposanteServiceFactory::class,
        ],
    ],

    /** Formulaires */
    'form_elements' => [
        'invokables' => [
        ],
        'factories' => [
            ComposanteForm::class => ComposanteFormFactory::class,
            ComposanteFieldset::class => ComposanteFieldsetFactory::class
        ],
    ],

    /** Hydrator */
    'hydrators' => [
        'invokables' => [
            ComposanteHydrator::class => ComposanteHydrator::class,
        ],
        'factories' => [
        ],
    ],

    /** Validateur */
    'validators' => [
        'factories' => [
            ComposanteActionsValidator::class => AbstractActionsValidatorFactory::class,
        ],
    ],

    'view_helpers' => [
        'aliases' => [
            'composante' => ComposanteViewHelper::class,
        ],
//        'invokables' => [
//            'composante' => ComposanteViewHelper::class,
//        ],
        'factories' => [
            ComposanteViewHelper::class => ComposanteViewHelperFactory::class
        ]
    ],

];
?>