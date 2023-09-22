<?php

namespace Message\Service\Message;

use Application\Service\Inscription\InscriptionService;
use Interop\Container\ContainerInterface;

class MessageServiceFactory {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $serviceProvider = new MessageService();

        $inscriptionService = $container->get(InscriptionService::class);
        $serviceProvider->setInscriptionService($inscriptionService);

        return $serviceProvider;
    }
}