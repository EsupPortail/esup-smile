<?php

namespace Application\Service\Langue;

use Interop\Container\Containerinterface;
use UnicaenAuthentification\Service\UserContext;

class LangueServiceFactory {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $sm = $container->get('ServiceManager');
        $translator = $sm->get('translator');

        $serviceProvider = new LangueService($translator);
        return $serviceProvider;
    }
}