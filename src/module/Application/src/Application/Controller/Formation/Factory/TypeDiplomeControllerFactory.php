<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller\Formation\Factory;

use Application\Application\Form\Formation\TypeDiplomeForm;
use Application\Application\Form\Misc\ConfirmationForm;
use Application\Application\Service\Formation\TypeDiplomeService;
use Application\Application\Validator\Actions\TypeDiplomeActionsValidator;
use Application\Controller\Formation\TypeDiplomeController;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Validator\ValidatorPluginManager;

class TypeDiplomeControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $controller = new TypeDiplomeController();

        /** @var ConfirmationForm $confirmationForm */
        $confirmationForm = $container->get('FormElementManager')->get(ConfirmationForm::class);
        $controller->setConfirmationForm($confirmationForm);

        /** @var TypeDiplomeService $entityService */
        $entityService = $container->get('ServiceManager')->get(TypeDiplomeService::class);
        $controller->setTypeDiplomeService($entityService);

        /** @var TypeDiplomeForm $entityForm */
        $entityForm = $container->get('FormElementManager')->get(TypeDiplomeForm::class);
        $controller->setTypeDiplomeForm($entityForm);

        /** @var TypeDiplomeActionsValidator $validator */
        $validator = $container->get(ValidatorPluginManager::class)->get(TypeDiplomeActionsValidator::class);
        $controller->setActionsValidator($validator);

        return $controller;
    }
}
