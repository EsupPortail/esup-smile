<?php
/**
 * Divers éléments globaux
 */

use Application\Application\Form\Misc\CodeValidator\CodeValidator;
use Application\Application\Form\Misc\CodeValidator\CodeValidatorFactory;
use Application\Application\Form\Misc\ConfirmationForm;
use Application\Application\Form\Misc\ConfirmationFormFactory;
use Application\Application\View\Helper\Evenement\TypeViewHelper;
use Application\Application\View\Helper\Form\ConfirmationViewHelper;
use Application\Application\View\Helper\Form\FormControlGroup;
use Application\Application\View\Helper\Form\FormControlText;
use Application\Application\View\Helper\Source\SourceViewHelper;
use Application\Application\View\Helper\Source\SourceViewHelperFactory;
use Application\Application\View\Renderer\BackButtonViewHelper;
use Application\Application\View\Renderer\FlashMessageDisplayViewHelper;
use Application\Application\View\Renderer\FlashMessageViewHelper;
use Application\Application\View\Renderer\FlashMessageViewHelperFactory;
use Application\Application\View\Renderer\HistoriqueViewHelper;
use Application\Controller\IndexController;
use UnicaenPrivilege\Guard\PrivilegeController;

return [
    /** Priviléges pour les actions */
    'bjyauthorize' => [
        'guards' => [
            PrivilegeController::class => [
                [
                    'controller' => IndexController::class,
                    'action' => [
                        'flash-message',
                    ],
                    'roles' => [
                        'user',
                    ],
                ],
            ],
        ],
    ],

    /** Routes pour les actions */
    'router' => [
        'routes' => [
            'flash-message' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/flash-message',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action' => 'flash-message',
                    ],
                ],
            ],
        ],
    ],

    /** Controlleurs */
    'controllers' => [
        'factories' => [
        ],
    ],

    /** Services */
    'service_manager' => [
        'factories' => [
        ],
    ],

    /** Formulaires */
    'form_elements' => [
        'invokables' => [
        ],
        'factories' => [
            ConfirmationForm::class => ConfirmationFormFactory::class,
        ],
    ],

    /** Hydrator */
    'hydrators' => [
        'factories' => [
        ],
    ],

    /** Validateur */
    'validators' => [
        'factories' => [
            CodeValidator::class => CodeValidatorFactory::class,
        ],
    ],

    'view_helpers' => [
        'aliases' => [
            'confirmation'=> ConfirmationViewHelper::class,
            'flashMessage' => FlashMessageViewHelper::class,
            'source' => SourceViewHelper::class,
            'historique' => HistoriqueViewHelper::class,
            'backButton' => BackButtonViewHelper::class,
        ],
        'invokables' => [
//            'flashMessage' => FlashMessageViewHelper::class,
            'flashMessageDisplay' => FlashMessageDisplayViewHelper::class,
            'confirmation' => ConfirmationViewHelper::class,
            'formControlText' => FormControlText::class,
            'formControlGroup' => FormControlGroup::class,
//            'source' => SourceViewHelper::class,
            'historique' => HistoriqueViewHelper::class,
            'backButton' => BackButtonViewHelper::class,
            'type'          => TypeViewHelper::class,
        ],
        'factories' => [
            FlashMessageViewHelper::class => FlashMessageViewHelperFactory::class,
            SourceViewHelper::class => SourceViewHelperFactory::class,
        ]
    ],

    /** Navigation */
    'navigation' => [
        'default' => [
            'home' => [
                'pages' => [
                ],
            ],
        ],
    ],
];
?>