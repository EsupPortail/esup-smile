<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller\Formation\Factory;

use Application\Application\Form\Formation\TypeFormationForm;
use Application\Application\Form\Misc\ConfirmationForm;
use Application\Application\Service\Formation\TypeFormationService;
use Application\Application\Validator\Actions\TypeFormationActionsValidator;
use Application\Controller\Formation\TypeFormationController;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Validator\ValidatorPluginManager;

class TypeFormationControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $controller = new TypeFormationController();

        /** @var ConfirmationForm $confirmationForm */
        $confirmationForm = $container->get('FormElementManager')->get(ConfirmationForm::class);
        $controller->setConfirmationForm($confirmationForm);

        /** @var TypeFormationService $entityService */
        $entityService = $container->get('ServiceManager')->get(TypeFormationService::class);
        $controller->setTypeFormationService($entityService);

        /** @var TypeFormationForm $entityForm */
        $entityForm = $container->get('FormElementManager')->get(TypeFormationForm::class);
        $controller->setTypeFormationForm($entityForm);

        /** @var TypeFormationActionsValidator $validator */
        $validator = $container->get(ValidatorPluginManager::class)->get(TypeFormationActionsValidator::class);
        $controller->setActionsValidator($validator);

        return $controller;
    }
}
