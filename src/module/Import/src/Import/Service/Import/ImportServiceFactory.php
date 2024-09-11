<?php

namespace Import\Service\Import;

use Application\Application\Service\Composante\ComposanteService;
use Application\Application\Service\Cours\CoursService;
use Application\Application\Service\Formation\FormationService;
use Application\Application\Service\Formation\TypeDiplomeService;
use Doctrine\ORM\EntityManager;
use Import\Service\MySynchro\MySynchroService;
use Interop\Container\ContainerInterface;
use UnicaenSynchro\Service\Synchronisation\SynchronisationService;
use UnicaenUtilisateur\Service\User\UserService;
use Laminas\ServiceManager\ServiceLocatorInterface;

class ImportServiceFactory {

    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('Config')['import'];
        /**
         * @var EntityManager $entityManager
         * @var UserService $userService
         */
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $userService = $container->get(UserService::class);

        $composanteService = $container->get(ComposanteService::class);

        $formationService = $container->get(FormationService::class);

        $coursService = $container->get(CoursService::class);

        $typeDiplomeService = $container->get(TypeDiplomeService::class);

        $mySynchroService = $container->get(MySynchroService::class);

        $service = new ImportService();
        $service->setConfig($config);
        $service->setEntityManager($entityManager);
        $service->setUserService($userService);
        $service->setComposanteService($composanteService);
        $service->setFormationService($formationService);
        $service->setCoursService($coursService);
        $service->setTypeDiplomeService($typeDiplomeService);
        $service->setMySynchroService($mySynchroService);
        return $service;
    }
}