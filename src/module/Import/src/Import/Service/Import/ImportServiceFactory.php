<?php

namespace Import\Service\Import;

use Application\Application\Service\Composante\ComposanteService;
use Application\Application\Service\Cours\CoursService;
use Application\Application\Service\Formation\FormationService;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use UnicaenUtilisateur\Service\User\UserService;
use Laminas\ServiceManager\ServiceLocatorInterface;

class ImportServiceFactory {

    public function __invoke(ContainerInterface $container)
    {
//        $path = $container->get('Config')['unicaen-import']['upload-path'];

        /**
         * @var EntityManager $entityManager
         * @var UserService $userService
         */
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $userService = $container->get(UserService::class);

        $composanteService = $container->get(ComposanteService::class);

        $formationService = $container->get(FormationService::class);

        $coursService = $container->get(CoursService::class);

        $service = new ImportService();
        $service->setEntityManager($entityManager);
        $service->setUserService($userService);
        $service->setComposanteService($composanteService);
        $service->setFormationService($formationService);
        $service->setCoursService($coursService);
        return $service;
    }
}