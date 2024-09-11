<?php

namespace Import\Service\MySynchro;

use Doctrine\ORM\EntityManager;
use Import\Service\SqlHelper\SqlHelperService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class MySynchroServiceFactory {

    /**
     * @param ContainerInterface $container
     * @return MySynchroService
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container) : MySynchroService
    {
        // récupération des entity managers déclarés
        $sources = $container->get('Config')['doctrine']['entitymanager'];
        $entityManagers = [];
        foreach ($sources as $id => $data) {
            $entityManagers[$id] = $container->get('doctrine.entitymanager.'. $id);
        }

        /** @var SqlHelperService $sqlHelper */
        $sqlHelper = $container->get(SqlHelperService::class);
        $configs = $container->get('Config')['synchros'];

        $service = new MySynchroService();
        $service->setSqlHelperService($sqlHelper);
        $service->setConfigs($configs);
        $service->setEntityManagers($entityManagers);
        return $service;
    }
}