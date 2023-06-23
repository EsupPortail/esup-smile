<?php

declare(strict_types=1);

namespace Application\Controller\Configuration\Factory;

use Application\Controller\Configuration\ConfigurationController;
use Application\Service\Inscription\InscriptionService;
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

        $entityService = $container->get('ServiceManager')->get(UserService::class);
        $controller->setUserService($entityService);
//
        $entityService = $container->get('ServiceManager')->get(InscriptionService::class);
        $controller->setInscriptionService($entityService);
//
        $entityService = $container->get('ServiceManager')->get(RoleService::class);
        $controller->setRoleService($entityService);

        $entityService = $container->get('ServiceManager')->get(StepService::class);
        $controller->setStepService($entityService);

        return $controller;
    }
}
