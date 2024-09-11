<?php

namespace Application\Service\Mobilite;

use Application\Application\Service\Cours\CoursService;
use Application\Service\Mobilite\MobiliteService;
use Interop\Container\Containerinterface;
use UnicaenAuthentification\Service\UserContext;

class MobiliteServiceFactory {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $serviceProvider = new MobiliteService();

        /** @var UserContext $userContext */
        $userContext = $container->get('authUserContext');
        $serviceProvider->setUserContext($userContext);

        $coursService = $container->get('ServiceManager')->get(CoursService::class);
        $serviceProvider->setCoursService($coursService);

        return $serviceProvider;
    }
}