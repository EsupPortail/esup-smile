<?php

namespace Application\Service\Mobilite;

use Application\Application\Service\Cours\CoursService;
use Application\Service\Mobilite\MobiliteService;
use Interop\Container\Containerinterface;

class MobiliteServiceFactory {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $serviceProvider = new MobiliteService();

        $coursService = $container->get('ServiceManager')->get(CoursService::class);
        $serviceProvider->setCoursService($coursService);

        return $serviceProvider;
    }
}