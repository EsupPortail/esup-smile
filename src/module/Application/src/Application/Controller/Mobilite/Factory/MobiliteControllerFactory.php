<?php

namespace Application\Controller\Mobilite\Factory;


use Application\Application\Service\Composante\ComposanteService;
use Application\Application\Service\Cours\CoursService;
use Application\Application\Service\Formation\FormationService;
use Application\Controller\Mobilite\MobiliteController;
use Application\Service\Document\DocumentService;
use Application\Service\Inscription\InscriptionService;
use Application\Service\Mobilite\MobiliteService;
use Laminas\Authentication\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use UnicaenUtilisateur\Service\User\UserService;
use Interop\Container\ContainerInterface;

class MobiliteControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $controller = new MobiliteController();

        $entityService = $container->get('ServiceManager')->get(MobiliteService::class);
        $controller->setMobiliteService($entityService);

        $entityService = $container->get('ServiceManager')->get(AuthenticationService::class);
        $controller->setAuthenticationService($entityService);

        $entityService = $container->get('ServiceManager')->get(InscriptionService::class);
        $controller->setInscriptionService($entityService);

        $entityService = $container->get('ServiceManager')->get(UserService::class);
        $controller->setUserService($entityService);

        $entityService = $container->get('ServiceManager')->get(FormationService::class);
        $controller->setFormationService($entityService);

        $documentService = $container->get('ServiceManager')->get(DocumentService::class);
        $controller->setDocumentService($documentService);

        $entityService = $container->get('ServiceManager')->get(CoursService::class);
        $controller->setCoursService($entityService);

        $entityService = $container->get('ServiceManager')->get(ComposanteService::class);
        $controller->setComposanteService($entityService);

        return $controller;
    }
}
