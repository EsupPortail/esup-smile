<?php

namespace Application\Service\Document;

use Application\Service\Document\DocumentService;
use Interop\Container\Containerinterface;

class DocumentServiceFactory {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $serviceProvider = new DocumentService();

        return $serviceProvider;
    }
}