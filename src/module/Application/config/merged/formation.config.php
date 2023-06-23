<?php
/**
 * Fichier de configurations vide pour avoir les clés de base
 * Basé sur UnicaenUtilisateur/UnicaenPrivileges
 */

use Application\Application\Form\Formation\Factory\FormationFieldsetFactory;
use Application\Application\Form\Formation\Factory\FormationFormFactory;
use Application\Application\Form\Formation\Factory\FormationHydratorFactory;
use Application\Application\Form\Formation\Factory\TypeDiplomeFieldsetFactory;
use Application\Application\Form\Formation\Factory\TypeDiplomeFormFactory;
use Application\Application\Form\Formation\Factory\TypeDiplomeHydratorFactory;
use Application\Application\Form\Formation\Factory\TypeFormationFieldsetFactory;
use Application\Application\Form\Formation\Factory\TypeFormationFormFactory;
use Application\Application\Form\Formation\Factory\TypeFormationHydratorFactory;
use Application\Application\Form\Formation\FormationFieldset;
use Application\Application\Form\Formation\FormationForm;
use Application\Application\Form\Formation\FormationHydrator;
use Application\Application\Form\Formation\TypeDiplomeFieldset;
use Application\Application\Form\Formation\TypeDiplomeForm;
use Application\Application\Form\Formation\TypeDiplomeHydrator;
use Application\Application\Form\Formation\TypeFormationFieldset;
use Application\Application\Form\Formation\TypeFormationForm;
use Application\Application\Form\Formation\TypeFormationHydrator;
use Application\Application\Service\Formation\FormationService;
use Application\Application\Service\Formation\FormationServiceFactory;
use Application\Application\Service\Formation\TypeDiplomeService;
use Application\Application\Service\Formation\TypeDiplomeServiceFactory;
use Application\Application\Service\Formation\TypeFormationService;
use Application\Application\Service\Formation\TypeFormationServiceFactory;
use Application\Application\Validator\Actions\Factory\AbstractActionsValidatorFactory;
use Application\Application\Validator\Actions\FormationActionsValidator;
use Application\Application\Validator\Actions\TypeDiplomeActionsValidator;
use Application\Application\Validator\Actions\TypeFormationActionsValidator;
use Application\Application\View\Helper\Formation\Factory\FormationViewHelperFactory;
use Application\Application\View\Helper\Formation\Factory\TypeDiplomeViewHelperFactory;
use Application\Application\View\Helper\Formation\Factory\TypeFormationViewHelperFactory;
use Application\Application\View\Helper\Formation\FormationViewHelper;
use Application\Application\View\Helper\Formation\TypeDiplomeViewHelper;
use Application\Application\View\Helper\Formation\TypeFormationViewHelper;
use Application\Controller\Formation\Factory\FormationControllerFactory;
use Application\Controller\Formation\Factory\TypeDiplomeControllerFactory;
use Application\Controller\Formation\Factory\TypeFormationControllerFactory;
use Application\Controller\Formation\FormationController;
use Application\Controller\Formation\TypeDiplomeController;
use Application\Controller\Formation\TypeFormationController;
use Application\Provider\Privilege\FormationPrivileges;
use Application\Service\Langue\LangueService;
use Application\Service\Langue\LangueServiceFactory;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use UnicaenPrivilege\Guard\PrivilegeController;

return [
    /** Priviléges pour les actions */
    'bjyauthorize' => [
        'guards' => [
            PrivilegeController::class => [
                [
                    'controller' => FormationController::class,
                    'action' => [
                        FormationController::ACTION_INDEX,
                        FormationController::ACTION_AFFICHER,
                        FormationController::ACTION_LISTER,
                        FormationController::ACTION_GET_ACTIONS_MENU,
                    ],
                    'privileges' => [
                        FormationPrivileges::FORMATION_INDEX
                    ],
                ],
                [
                    'controller' => FormationController::class,
                    'action' => [
                        FormationController::ACTION_AJOUTER,
                    ],
                    'privileges' => [
                        FormationPrivileges::FORMATION_AJOUTER
                    ],
                ],
                [
                    'controller' => FormationController::class,
                    'action' => [
                        FormationController::ACTION_MODIFIER,
                        FormationController::ACTION_ARCHIVER,
                        FormationController::ACTION_RESTAURER,
                    ],
                    'privileges' => [
                        FormationPrivileges::FORMATION_MODIFIER
                    ],
                ],
                [
                    'controller' => FormationController::class,
                    'action' => [
                        FormationController::ACTION_SUPPRIMER,
                    ],
                    'privileges' => [
                        FormationPrivileges::FORMATION_SUPPRIMER
                    ],
                ],
//
                [
                    'controller' => TypeFormationController::class,
                    'action' => [
                        TypeFormationController::ACTION_INDEX,
                        TypeFormationController::ACTION_LISTER,
                    ],
                    'privileges' => [
                        FormationPrivileges::FORMATION_PARAMETRE_AFFICHER
                    ],
                ],
                [
                    'controller' => TypeFormationController::class,
                    'action' => [
                        TypeFormationController::ACTION_GET_ACTIONS_MENU,
                        TypeFormationController::ACTION_AJOUTER,
                        TypeFormationController::ACTION_MODIFIER,
                        TypeFormationController::ACTION_SUPPRIMER,
                    ],
                    'privileges' => [
                        FormationPrivileges::FORMATION_PARAMETRE_MODIFIER
                    ],
                ],
                [
                    'controller' => TypeDiplomeController::class,
                    'action' => [
                        TypeDiplomeController::ACTION_INDEX,
                        TypeDiplomeController::ACTION_LISTER,
                    ],
                    'privileges' => [
                        FormationPrivileges::FORMATION_PARAMETRE_AFFICHER
                    ],
                ],
                [
                    'controller' => TypeDiplomeController::class,
                    'action' => [
                        TypeDiplomeController::ACTION_GET_ACTIONS_MENU,
                        TypeDiplomeController::ACTION_AJOUTER,
                        TypeDiplomeController::ACTION_MODIFIER,
                        TypeDiplomeController::ACTION_SUPPRIMER,
                    ],
                    'privileges' => [
                        FormationPrivileges::FORMATION_PARAMETRE_MODIFIER
                    ],
                ],
                [
                    'controller' => FormationController::class,
                    'action' => [
                        FormationController::ACTION_MOBILITE,
                        FormationController::ACTION_SAVE_MOBILITE,
                        FormationController::ACTION_ACTIVE_ALLMOBILITY,
                        FormationController::ACTION_DESCRIPTIF,
                    ],
                    'privileges' => [
                        FormationPrivileges::FORMATION_MOBILITE
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
            'formations' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/formations',
                    'defaults' => [
                        'controller' => FormationController::class,
                        'action' => FormationController::ACTION_INDEX,
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'lister' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/lister',
                            'defaults' => [
                                'controller' => FormationController::class,
                                'action' => FormationController::ACTION_LISTER,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'mobilite' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/mobilite',
                            'defaults' => [
                                'controller' => FormationController::class,
                                'action' => FormationController::ACTION_MOBILITE,
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'descriptif' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/[:uuid]',
                                    'constraints' => [
                                        'slug' => '[a-zA-Z0-9_-]+',
                                    ],
                                    'defaults' => [
                                        'controller' => FormationController::class,
                                        'action' => FormationController::ACTION_DESCRIPTIF,
                                    ],
                                ]
                            ],
                            'activeAllMobility' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/activeAllMobility',
                                    'defaults' => [
                                        'controller' => FormationController::class,
                                        'action' => FormationController::ACTION_ACTIVE_ALLMOBILITY,
                                    ],
                                ]
                            ],
                        ]
                    ],
                    'saveMobilite' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/saveMobilite',
                            'defaults' => [
                                'controller' => FormationController::class,
                                'action' => FormationController::ACTION_SAVE_MOBILITE,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                ],
            ],
            'formation' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/formation',
                ],
                'may_terminate' => false,
                'child_routes' => [
                    'afficher' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/afficher/:formation',
                            'constraints' => [
                                'formation' => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => FormationController::class,
                                'action' => FormationController::ACTION_AFFICHER,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'ajouter' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/ajouter',
                            'defaults' => [
                                'controller' => FormationController::class,
                                'action' => FormationController::ACTION_AJOUTER,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'modifier' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/modifier/:formation',
                            'constraints' => [
                                'formation' => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => FormationController::class,
                                'action' => FormationController::ACTION_MODIFIER,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'archiver' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/archiver/:formation',
                            'constraints' => [
                                'formation' => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => FormationController::class,
                                'action' => FormationController::ACTION_ARCHIVER,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'restaurer' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/restaurer/:formation',
                            'constraints' => [
                                'formation' => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => FormationController::class,
                                'action' => FormationController::ACTION_RESTAURER,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'supprimer' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/supprimer/:formation',
                            'constraints' => [
                                'formation' => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => FormationController::class,
                                'action' => FormationController::ACTION_SUPPRIMER,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'actions' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/actions/:formation',
                            'constraints' => [
                                'formation' => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => FormationController::class,
                                'action' => FormationController::ACTION_GET_ACTIONS_MENU,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                ],
            ],
            'types-formations' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/types-formations',
                    'defaults' => [
                        'controller' => TypeFormationController::class,
                        'action' => TypeFormationController::ACTION_INDEX,
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'lister' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/lister',
                            'defaults' => [
                                'controller' => TypeFormationController::class,
                                'action' => TypeFormationController::ACTION_LISTER,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                ],
            ],
            'type-formation' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/type-formation',
                ],
                'may_terminate' => false,
                'child_routes' => [
                    'ajouter' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/ajouter',
                            'defaults' => [
                                'controller' => TypeFormationController::class,
                                'action' => TypeFormationController::ACTION_AJOUTER,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'modifier' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/modifier/:typeFormation',
                            'constraints' => [
                                'typeFormation' => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => TypeFormationController::class,
                                'action' => TypeFormationController::ACTION_MODIFIER,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'supprimer' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/supprimer/:typeFormation',
                            'constraints' => [
                                'typeFormation' => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => TypeFormationController::class,
                                'action' => TypeFormationController::ACTION_SUPPRIMER,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'actions' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/actions/:typeFormation',
                            'constraints' => [
                                'typeFormation' => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => TypeFormationController::class,
                                'action' => TypeFormationController::ACTION_GET_ACTIONS_MENU,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                ],
            ],
            'types-diplomes' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/types-diplomes',
                    'defaults' => [
                        'controller' => TypeDiplomeController::class,
                        'action' => TypeDiplomeController::ACTION_INDEX,
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'lister' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/lister',
                            'defaults' => [
                                'controller' => TypeDiplomeController::class,
                                'action' => TypeDiplomeController::ACTION_LISTER,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                ],
            ],
            'type-diplome' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/type-diplome',
                ],
                'may_terminate' => false,
                'child_routes' => [
                    'ajouter' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/ajouter',
                            'defaults' => [
                                'controller' => TypeDiplomeController::class,
                                'action' => TypeDiplomeController::ACTION_AJOUTER,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'modifier' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/modifier/:typeDiplome',
                            'constraints' => [
                                'typeDiplome' => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => TypeDiplomeController::class,
                                'action' => TypeDiplomeController::ACTION_MODIFIER,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'supprimer' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/supprimer/:typeDiplome',
                            'constraints' => [
                                'typeDiplome' => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => TypeDiplomeController::class,
                                'action' => TypeDiplomeController::ACTION_SUPPRIMER,
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'actions' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/actions/:typeDiplome',
                            'constraints' => [
                                'typeDiplome' => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => TypeDiplomeController::class,
                                'action' => TypeDiplomeController::ACTION_GET_ACTIONS_MENU,
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
            FormationController::class => FormationControllerFactory::class,
            TypeFormationController::class => TypeFormationControllerFactory::class,
            TypeDiplomeController::class => TypeDiplomeControllerFactory::class,
        ],
    ],

    /** Services */
    'service_manager' => [
        'factories' => [
            FormationService::class => FormationServiceFactory::class,
            TypeFormationService::class => TypeFormationServiceFactory::class,
            TypeDiplomeService::class => TypeDiplomeServiceFactory::class,
            LangueService::class => LangueServiceFactory::class,
        ],
    ],

    /** Formulaires */
    'form_elements' => [
        'factories' => [
            FormationForm::class => FormationFormFactory::class,
            FormationFieldset::class =>FormationFieldsetFactory::class,
            TypeFormationForm::class => TypeFormationFormFactory::class,
            TypeFormationFieldset::class => TypeFormationFieldsetFactory::class,
            TypeDiplomeForm::class => TypeDiplomeFormFactory::class,
            TypeDiplomeFieldset::class => TypeDiplomeFieldsetFactory::class,
        ],
    ],

    /** Hydrator */
    'hydrators' => [
        'invokables' => [
//            TypeFormationHydrator::class => TypeFormationHydrator::class,
        ],
        'factories' => [
            FormationHydrator::class => FormationHydratorFactory::class,
            TypeFormationHydrator::class => TypeFormationHydratorFactory::class,
            TypeDiplomeHydrator::class => TypeDiplomeHydratorFactory::class,
        ],
    ],

    /** Validateur */
    'validators' => [
        'factories' => [
            FormationActionsValidator::class => AbstractActionsValidatorFactory::class,
            TypeFormationActionsValidator::class => AbstractActionsValidatorFactory::class,
            TypeDiplomeActionsValidator::class => AbstractActionsValidatorFactory::class,
        ],
    ],

    'view_helpers' => [
        'aliases' => [
            'formation' => FormationViewHelper::class,
            'typeFormation' => TypeFormationViewHelper::class,
            'typeDiplome' => TypeDiplomeViewHelper::class,
        ],
        'factories' => [
            FormationViewHelper::class => FormationViewHelperFactory::class,
            TypeFormationViewHelper::class => TypeFormationViewHelperFactory::class,
            TypeDiplomeViewHelper::class => TypeDiplomeViewHelperFactory::class,
        ]
    ],
];
?>