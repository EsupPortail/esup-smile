<?php

declare(strict_types=1);

namespace Application\Controller\Configuration\Factory;

use Application\Application\Service\Composante\ComposanteService;
use Application\Controller\Configuration\ConfigurationController;
use Application\Service\Inscription\InscriptionService;
use Application\Service\Step\StepMessageService;
use Application\Service\Step\StepService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use UnicaenUtilisateur\Service\Role\RoleService;
use UnicaenUtilisateur\Service\User\UserService;

class ConfigurationControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return ConfigurationController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new ConfigurationController($container->get(\Doctrine\ORM\EntityManager::class));

//        $entityService = $container->get('ServiceManager')->get(ConfigurationService::class);
//        $controller->setConfigurationService($entityService);

        $userService = $container->get('ServiceManager')->get(UserService::class);
        $controller->setUserService($userService);
//
        $inscriptionService = $container->get('ServiceManager')->get(InscriptionService::class);
        $controller->setInscriptionService($inscriptionService);
//
        $roleService = $container->get('ServiceManager')->get(RoleService::class);
        $controller->setRoleService($roleService);

        $stepService = $container->get('ServiceManager')->get(StepService::class);
        $controller->setStepService($stepService);

        $composanteService = $container->get('ServiceManager')->get(ComposanteService::class);
        $controller->setComposanteService($composanteService);

        $stepMessageService = $container->get('ServiceManager')->get(StepMessageService::class);
        $controller->setStepMessageService($stepMessageService);

        return $controller;
    }
}
