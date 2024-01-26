<?php

declare(strict_types=1);

namespace Application\Controller\Inscription\Factory;


use Application\Controller\Inscription\InscriptionController;
use Application\Service\Dashboard\DashboardService;
use Application\Service\Document\DocumentService;
use Application\Service\Etablissement\EtablissementService;
use Application\Service\Inscription\InscriptionService;
use Application\Service\Mobilite\MobiliteService;
use Application\Service\Step\StepService;
use Fichier\Service\Fichier\FichierService;
use Fichier\Service\Nature\NatureService;
use Laminas\Authentication\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use UnicaenAuthentification\Service\ShibService;
use UnicaenUtilisateur\Service\Role\RoleService;
use UnicaenUtilisateur\Service\User\UserService;

class InscriptionControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return InscriptionController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new InscriptionController($container->get(\Doctrine\ORM\EntityManager::class));

        $inscriptionService = $container->get('ServiceManager')->get(InscriptionService::class);
        $controller->setInscriptionService($inscriptionService);

        $userService = $container->get('ServiceManager')->get(UserService::class);
        $controller->setUserService($userService);

        $authService = $container->get('ServiceManager')->get(AuthenticationService::class);
        $controller->setAuthenticationService($authService);

        $roleService = $container->get('ServiceManager')->get(RoleService::class);
        $controller->setRoleService($roleService);

        $shibService = $container->get('ServiceManager')->get(ShibService::class);
        $controller->setShibService($shibService);

        $stepService = $container->get('ServiceManager')->get(StepService::class);
        $controller->setStepService($stepService);

        $documentService = $container->get('ServiceManager')->get(DocumentService::class);
        $controller->setDocumentService($documentService);

        $mobiliteService = $container->get('ServiceManager')->get(MobiliteService::class);
        $controller->setMobiliteService($mobiliteService);

        $fichierService = $container->get('ServiceManager')->get(FichierService::class);
        $controller->setFichierService($fichierService);

        $natureService = $container->get('ServiceManager')->get(NatureService::class);
        $controller->setNatureService($natureService);

        $etablissementService = $container->get('ServiceManager')->get(EtablissementService::class);
        $controller->setEtablissementService($etablissementService);

        return $controller;
    }
}
