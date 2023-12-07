<?php

namespace Import\Controller;

use Doctrine\ORM\EntityManager;
use Import\Service\Import\ImportService;
use Interop\Container\ContainerInterface;
use Laminas\Mvc\Controller\ControllerManager;
use UnicaenApp\Service\EntityManagerAwareTrait;

class IndexControllerFactory {

    public function __invoke(ContainerInterface $container)
    {
        $em = $container->get(EntityManager::class);
        $importService = $container->get(ImportService::class);
        /** @var IndexController $controller */
        $controller = new IndexController();
        $controller->setEntityManager($em);
        $controller->setImportService($importService);
        return $controller;
    }
}