<?php

namespace Application\Service\Inscription;

use Interop\Container\Containerinterface;
use UnicaenAuthentification\Service\UserContext;

class InscriptionServiceFactory {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $serviceProvider = new InscriptionService();

        /** @var UserContext $userContext */
        $userContext = $container->get('authUserContext');
        $serviceProvider->setUserContext($userContext);

        return $serviceProvider;
    }
}