<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller\Formation\Factory;

use Application\Application\Form\Formation\FormationForm;
use Application\Application\Form\Misc\ConfirmationForm;
use Application\Application\Service\Composante\ComposanteService;
use Application\Application\Service\Cours\CoursService;
use Application\Application\Service\Formation\FormationService;
use Application\Application\Validator\Actions\FormationActionsValidator;
use Application\Controller\Formation\FormationController;
use Application\Service\Langue\LangueService;
use Application\Service\Mobilite\MobiliteService;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Validator\ValidatorPluginManager;
use UnicaenDbImport\Entity\Db\Service\Source\SourceService;
use UnicaenUtilisateur\Service\User\UserService;

class FormationControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $controller = new FormationController();

        /** @var FormationService $entityService */
        $entityService = $container->get('ServiceManager')->get(FormationService::class);
        $controller->setFormationService($entityService);

        /** @var ComposanteService $entityService */
        $entityService = $container->get('ServiceManager')->get(ComposanteService::class);
        $controller->setComposanteService($entityService);

        /** @var MobiliteService $entityService */
        $entityService = $container->get('ServiceManager')->get(MobiliteService::class);
        $controller->setMobiliteService($entityService);

        /** @var CoursService $entityService */
        $entityService = $container->get('ServiceManager')->get(CoursService::class);
        $controller->setCoursService($entityService);

        /** @var LangueService $entityService */
        $entityService = $container->get('ServiceManager')->get(LangueService::class);
        $controller->setLangueService($entityService);

        /** @var UserService $entityService */
        $userService = $container->get('ServiceManager')->get(UserService::class);
        $controller->setUserService($userService);

        /** @var ConfirmationForm $confirmationForm */
        $confirmationForm = $container->get('FormElementManager')->get(ConfirmationForm::class);
        $controller->setConfirmationForm($confirmationForm);


        $entityManager = $container->get(EntityManager::class);
        $controller->setEntityManager($entityManager);

        /** @var FormationForm $entityForm */
        $entityForm = $container->get('FormElementManager')->get(FormationForm::class);
        $controller->setFormationForm($entityForm);

        /** @var FormationActionsValidator $validator */
        $validator = $container->get(ValidatorPluginManager::class)->get(FormationActionsValidator::class);
        $controller->setActionsValidator($validator);

        return $controller;
    }
}
