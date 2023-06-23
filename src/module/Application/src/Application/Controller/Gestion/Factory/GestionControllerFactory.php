<?php

declare(strict_types=1);

namespace Application\Controller\Gestion\Factory;


use Application\Controller\Gestion\GestionController;
use Application\Entity\Step;
use Application\Service\Dashboard\DashboardService;
use Application\Service\Document\DocumentService;
use Application\Service\Inscription\InscriptionService;
use Application\Service\Step\StepService;
use Fichier\Service\Fichier\FichierService;
use Laminas\Authentication\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use UnicaenAuthentification\Service\ShibService;
use UnicaenUtilisateur\Service\Role\RoleService;
use UnicaenUtilisateur\Service\User\UserService;

class GestionControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return GestionController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new GestionController($container->get(\Doctrine\ORM\EntityManager::class));

//        $entityService = $container->get('ServiceManager')->get(GestionService::class);
//        $controller->setGestionService($entityService);

        $entityService = $container->get('ServiceManager')->get(UserService::class);
        $controller->setUserService($entityService);
//
        $entityService = $container->get('ServiceManager')->get(InscriptionService::class);
        $controller->setInscriptionService($entityService);
//
        $entityService = $container->get('ServiceManager')->get(RoleService::class);
        $controller->setRoleService($entityService);

        $entityService = $container->get('ServiceManager')->get(StepService::class);
        $controller->setStepService($entityService);

        $entityService = $container->get('ServiceManager')->get(FichierService::class);
        $controller->setFichierService($entityService);

        $entityService = $container->get('ServiceManager')->get(DocumentService::class);
        $controller->setDocumentService($entityService);

//        $entityManager = $container->get('EntityService')->get(Step::class);
//        $controller->entityManagerStep = $entityManager;
//
//        $entityService = $container->get('ServiceManager')->get(ShibService::class);
//        $controller->setShibService($entityService);

        return $controller;
    }
}
