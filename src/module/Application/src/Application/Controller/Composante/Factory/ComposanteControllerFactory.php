<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller\Composante\Factory;

use Application\Application\Form\Composante\ComposanteForm;
use Application\Application\Form\Misc\ConfirmationForm;
use Application\Application\Service\Composante\ComposanteService;
use Application\Application\Validator\Actions\ComposanteActionsValidator;
use Application\Controller\Composante\ComposanteController;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Validator\ValidatorPluginManager;
use UnicaenEvenement\Service\EvenementGestion\EvenementGestionService;

class ComposanteControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        /** @var ComposanteController $controller */
        $controller = new ComposanteController();
        /** @var ComposanteService $entityService */
        $entityService = $container->get('ServiceManager')->get(ComposanteService::class);
        $controller->setComposanteService($entityService);

        /** @var ComposanteForm $entityForm */
        $entityForm = $container->get('FormElementManager')->get(ComposanteForm::class);
        $controller->setComposanteForm($entityForm);

        /** @var ConfirmationForm $confirmationForm */
        $confirmationForm = $container->get('FormElementManager')->get(ConfirmationForm::class);
        $controller->setConfirmationForm($confirmationForm);

        /** @var ComposanteActionsValidator $validator */
        $validator = $container->get(ValidatorPluginManager::class)->get(ComposanteActionsValidator::class);
        $controller->setActionsValidator($validator);

        return $controller;
    }
}
