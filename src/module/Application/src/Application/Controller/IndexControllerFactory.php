<?php

namespace Application\Controller;


use Application\Controller\Dashboard\DashboardController;
use Application\Controller\IndexController;
use Application\Service\Dashboard\DashboardService;
use Application\Service\Inscription\InscriptionService;
use Laminas\Authentication\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use UnicaenAuthentification\Service\ShibService;
use UnicaenUtilisateur\Service\User\UserService;

class IndexControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {


        $controller = new IndexController();

        $authConf = $container->get('config')['unicaen-auth'];
        $controller->setAuthConfig($authConf);

        $entityService = $container->get('ServiceManager')->get(UserService::class);
        $controller->setUserService($entityService);

        $entityService = $container->get('ServiceManager')->get(ShibService::class);
        $controller->setShibService($entityService);

        $entityService = $container->get('ServiceManager')->get(InscriptionService::class);
        $controller->setInscriptionService($entityService);

        $entityService = $container->get('ServiceManager')->get(AuthenticationService::class);
        $controller->setAuthenticationService($entityService);

//        $translator = $container->get('ServiceManager')->get('translator');
//        $controller->setTranslator($translator);

        return $controller;
    }
}
