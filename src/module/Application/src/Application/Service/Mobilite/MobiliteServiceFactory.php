<?php

namespace Application\Service\Mobilite;

use Application\Service\Mobilite\MobiliteService;
use Interop\Container\Containerinterface;

class MobiliteServiceFactory {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $serviceProvider = new MobiliteService();

        return $serviceProvider;
    }
}