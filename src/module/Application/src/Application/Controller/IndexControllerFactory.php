<?php

namespace Application\Controller;


use Application\Application\Service\Calendar\CalendarService;
use Application\Controller\Dashboard\DashboardController;
use Application\Controller\IndexController;
use Application\Service\Dashboard\DashboardService;
use Application\Service\Inscription\InscriptionService;
use Application\Service\Langue\LangueService;
use Laminas\Authentication\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use UnicaenAuthentification\Service\ShibService;
use UnicaenParametre\Service\Parametre\ParametreService;
use UnicaenRenderer\Service\Rendu\RenduService;
use UnicaenUtilisateur\Service\User\UserService;

class IndexControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {


        $controller = new IndexController();

        $authConf = $container->get('config')['unicaen-auth'];
        $controller->setAuthConfig($authConf);

        $userService = $container->get('ServiceManager')->get(UserService::class);
        $controller->setUserService($userService);

        $shibService = $container->get('ServiceManager')->get(ShibService::class);
        $controller->setShibService($shibService);

        $inscriptionService = $container->get('ServiceManager')->get(InscriptionService::class);
        $controller->setInscriptionService($inscriptionService);

        $authService = $container->get('ServiceManager')->get(AuthenticationService::class);
        $controller->setAuthenticationService($authService);

        $calendarService = $container->get('ServiceManager')->get(CalendarService::class);
        $controller->setCalendarService($calendarService);

        $languageService = $container->get('ServiceManager')->get(LangueService::class);
        $controller->setLangueService($languageService);

        $renduService = $container->get('ServiceManager')->get(RenduService::class);
        $controller->setRenduService($renduService);

        return $controller;
    }
}
