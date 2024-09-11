<?php

namespace Fichier\Service\S3;

use Interop\Container\ContainerInterface;

class S3ServiceFactory {

    public function __invoke(ContainerInterface $container)
    {
        $service = new S3Service();
        return $service;
    }
}