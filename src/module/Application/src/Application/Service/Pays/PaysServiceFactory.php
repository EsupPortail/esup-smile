<?php

namespace Application\Service\Pays;

use Interop\Container\Containerinterface;

class PaysServiceFactory {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $serviceProvider = new PaysService();

        return $serviceProvider;
    }
}