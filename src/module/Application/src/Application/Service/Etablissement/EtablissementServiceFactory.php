<?php

namespace Application\Service\Etablissement;

use Application\Service\Pays\PaysService;
use Interop\Container\Containerinterface;

class EtablissementServiceFactory {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $serviceProvider = new EtablissementService();

        /** @var PaysService $entityService */
        $entityService = $container->get('ServiceManager')->get(PaysService::class);
        $serviceProvider->setPaysService($entityService);

        return $serviceProvider;
    }
}