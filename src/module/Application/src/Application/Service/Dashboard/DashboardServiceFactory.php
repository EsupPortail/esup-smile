<?php

namespace Application\Service\Dashboard;

use Interop\Container\Containerinterface;
use UnicaenAuthentification\Service\UserContext;

class DashboardServiceFactory {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $serviceProvider = new DashboardService();

        return $serviceProvider;
    }
}