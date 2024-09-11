<?php

namespace Fichier\Service\Fichier;

use Doctrine\ORM\EntityManager;
use Fichier\Service\S3\S3Service;
use Interop\Container\ContainerInterface;
use UnicaenUtilisateur\Service\User\UserService;
use Laminas\ServiceManager\ServiceLocatorInterface;

class FichierServiceFactory {

    public function __invoke(ContainerInterface $container)
    {
        $path = $container->get('Config')['unicaen-fichier']['upload-path'];
        $s3 = $container->get('Config')['unicaen-fichier']['s3'];

        /**
         * @var EntityManager $entityManager
         * @var UserService $userService
         */
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $userService = $container->get(UserService::class);
        $s3Service = $container->get(S3Service::class);

        $service = new FichierService();
        $service->setEntityManager($entityManager);
        $service->setUserService($userService);
        $service->setS3Service($s3Service);
        $service->setPath($path);
        $service->setS3($s3);
        return $service;
    }
}