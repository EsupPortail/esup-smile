<?php

namespace Application\Controller\Authenticate\Factory;


use Application\Controller\Authenticate\AuthenticateController;
use Application\Controller\Dashboard\DashboardController;
use Application\Service\Dashboard\DashboardService;
use Application\Service\Inscription\InscriptionService;
use Laminas\Authentication\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use UnicaenAuthentification\Service\ShibService;
use UnicaenUtilisateur\Service\Role\RoleService;
use UnicaenUtilisateur\Service\User\UserService;

class AuthenticateControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $controller = new AuthenticateController($container->get(\Doctrine\ORM\EntityManager::class));

        $entityService = $container->get('ServiceManager')->get(ShibService::class);
        $controller->setShibService($entityService);

        $entityService = $container->get('ServiceManager')->get(AuthenticationService::class);
        $controller->setAuthenticationService($entityService);

        $entityService = $container->get('ServiceManager')->get(RoleService::class);
        $controller->setRoleService($entityService);

        $entityService = $container->get('ServiceManager')->get(InscriptionService::class);
        $controller->setInscriptionService($entityService);

        $entityService = $container->get('ServiceManager')->get(UserService::class);
        $controller->setUserService($entityService);

        return $controller;
    }
}
