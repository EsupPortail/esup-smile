<?php

namespace Import\Controller;

use Doctrine\ORM\EntityManager;
use Fichier\Service\S3\S3Service;
use Import\Service\Import\ImportService;
use Interop\Container\ContainerInterface;
use Laminas\Mvc\Controller\ControllerManager;
use UnicaenApp\Service\EntityManagerAwareTrait;

class IndexControllerFactory {

    public function __invoke(ContainerInterface $container)
    {
        $em = $container->get(EntityManager::class);
        $importService = $container->get(ImportService::class);
        $s3Service = $container->get(S3Service::class);

        /** @var IndexController $controller */
        $controller = new IndexController();
        $controller->setEntityManager($em);
        $controller->setImportService($importService);
        $controller->setS3Service($s3Service);
        return $controller;
    }
}