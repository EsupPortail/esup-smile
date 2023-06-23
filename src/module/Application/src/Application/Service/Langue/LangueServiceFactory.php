<?php

namespace Application\Service\Langue;

use Interop\Container\Containerinterface;
use UnicaenAuthentification\Service\UserContext;

class LangueServiceFactory {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $serviceProvider = new LangueService();

        return $serviceProvider;
    }
}