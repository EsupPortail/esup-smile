<?php

namespace SmileAuthentification\Service\SmileAuthentification;

use Application\Service\Inscription\InscriptionService;
use Interop\Container\ContainerInterface;
use SmileAuthentification\Service\SmileAuthentification\SmileAuthentificationService;

class SmileAuthentificationServiceFactory {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $serviceProvider = new SmileAuthentificationService();


        return $serviceProvider;
    }
}