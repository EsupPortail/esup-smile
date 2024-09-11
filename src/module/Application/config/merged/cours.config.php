<?php
/**
 * Fichier de configurations vide pour avoir les clés de base
 * Basé sur UnicaenUtilisateur/UnicaenPrivileges
 */

use Application\Application\Form\Cours\Factory\CoursFieldsetFactory;
use Application\Application\Form\Cours\Factory\CoursFormFactory;
use Application\Application\Form\Cours\Factory\CoursHydratorFactory;
use Application\Application\Form\Cours\Factory\TypeDiplomeFieldsetFactory;
use Application\Application\Form\Cours\Factory\TypeDiplomeFormFactory;
use Application\Application\Form\Cours\Factory\TypeDiplomeHydratorFactory;
use Application\Application\Form\Cours\Factory\TypeCoursFieldsetFactory;
use Application\Application\Form\Cours\Factory\TypeCoursFormFactory;
use Application\Application\Form\Cours\Factory\TypeCoursHydratorFactory;
use Application\Application\Form\Cours\CoursFieldset;
use Application\Application\Form\Cours\CoursForm;
use Application\Application\Form\Cours\CoursHydrator;
use Application\Application\Form\Cours\TypeDiplomeFieldset;
use Application\Application\Form\Cours\TypeDiplomeForm;
use Application\Application\Form\Cours\TypeDiplomeHydrator;
use Application\Application\Form\Cours\TypeCoursFieldset;
use Application\Application\Form\Cours\TypeCoursForm;
use Application\Application\Form\Cours\TypeCoursHydrator;
use Application\Application\Service\Cours\CoursService;
use Application\Application\Service\Cours\CoursServiceFactory;
use Application\Application\Service\Cours\TypeDiplomeService;
use Application\Application\Service\Cours\TypeDiplomeServiceFactory;
use Application\Application\Service\Cours\TypeCoursService;
use Application\Application\Service\Cours\TypeCoursServiceFactory;
use Application\Application\Validator\Actions\Factory\AbstractActionsValidatorFactory;
use Application\Application\Validator\Actions\CoursActionsValidator;
use Application\Application\Validator\Actions\TypeDiplomeActionsValidator;
use Application\Application\Validator\Actions\TypeCoursActionsValidator;
use Application\Application\View\Helper\Cours\Factory\CoursViewHelperFactory;
use Application\Application\View\Helper\Cours\Factory\TypeDiplomeViewHelperFactory;
use Application\Application\View\Helper\Cours\Factory\TypeCoursViewHelperFactory;
use Application\Application\View\Helper\Cours\CoursViewHelper;
use Application\Application\View\Helper\Cours\TypeDiplomeViewHelper;
use Application\Application\View\Helper\Cours\TypeCoursViewHelper;
use Application\Controller\Cours\Factory\CoursControllerFactory;
use Application\Controller\Cours\Factory\TypeDiplomeControllerFactory;
use Application\Controller\Cours\Factory\TypeCoursControllerFactory;
use Application\Controller\Cours\CoursController;
use Application\Controller\Cours\TypeDiplomeController;
use Application\Controller\Cours\TypeCoursController;
use Application\Provider\Privilege\CoursPrivileges;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use UnicaenPrivilege\Guard\PrivilegeController;

return [
    /** Priviléges pour les actions */
    'bjyauthorize' => [
        'guards' => [
            PrivilegeController::class => [
               
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
            CoursService::class => CoursServiceFactory::class,
        ],
    ],

    /** Formulaires */
    'form_elements' => [
        'factories' => [
        ],
    ],

    /** Hydrator */
    'hydrators' => [
        'invokables' => [
        ],
        'factories' => [

        ],
    ],

    /** Validateur */
    'validators' => [
        'factories' => [
        ],
    ],

    'view_helpers' => [
    ],
];
?>