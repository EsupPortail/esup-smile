<?php

namespace Application\Controller\Dashboard\Factory;


use Application\Application\Service\Composante\ComposanteService;
use Application\Application\Service\Cours\CoursService;
use Application\Application\Service\Formation\FormationService;
use Application\Controller\Dashboard\DashboardController;
use Application\Service\Dashboard\DashboardService;
use Application\Service\Document\DocumentService;
use Application\Service\Inscription\InscriptionService;
use Application\Service\Langue\LangueService;
use Application\Service\Step\StepService;
use Fichier\Form\Upload\UploadForm;
use Fichier\Service\Fichier\FichierService;
use Fichier\Service\Nature\NatureService;
use Laminas\Authentication\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Message\Service\Message\MessageService;
use UnicaenParametre\Service\Parametre\ParametreService;
use UnicaenRenderer\Service\Rendu\RenduService;
use UnicaenUtilisateur\Service\User\UserService;

class DashboardControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $controller = new DashboardController();

        $entityService = $container->get('ServiceManager')->get(DashboardService::class);
        $controller->setDashboardService($entityService);

        $entityService = $container->get(NatureService::class);
        $controller->setNatureService($entityService);

        $entityService = $container->get(FichierService::class);
        $controller->setFichierService($entityService);

        $documentService = $container->get(DocumentService::class);
        $controller->setDocumentService($documentService);

        $formUpload = $container->get('FormElementManager')->get(UploadForm::class);
        $controller->setUploadForm($formUpload);

        $entityService = $container->get('ServiceManager')->get(AuthenticationService::class);
        $controller->setAuthenticationService($entityService);

        $entityService = $container->get('ServiceManager')->get(InscriptionService::class);
        $controller->setInscriptionService($entityService);

        $entityService = $container->get('ServiceManager')->get(UserService::class);
        $controller->setUserService($entityService);

        $entityService = $container->get('ServiceManager')->get(FormationService::class);
        $controller->setFormationService($entityService);

        $entityService = $container->get('ServiceManager')->get(CoursService::class);
        $controller->setCoursService($entityService);

        $entityService = $container->get('ServiceManager')->get(ComposanteService::class);
        $controller->setComposanteService($entityService);

        $entityService = $container->get('ServiceManager')->get(StepService::class);
        $controller->setStepService($entityService);

        $entityService = $container->get('ServiceManager')->get(LangueService::class);
        $controller->setLangueService($entityService);

        $renduService = $container->get('ServiceManager')->get(RenduService::class);
        $controller->setRenduService($renduService);

        $parametreService = $container->get('ServiceManager')->get(ParametreService::class);
        $controller->setParametreService($parametreService);

        $messageService = $container->get('ServiceManager')->get(MessageService::class);
        $controller->setMessageService($messageService);

//        $container->get('')
        $renderer = $container->get('ServiceManager')->get('ViewRenderer');
        $controller->setRenderer($renderer);

        return $controller;
    }
}
