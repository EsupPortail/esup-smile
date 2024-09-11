<?php

namespace Application\Service\Step;

use Application\Service\Document\DocumentService;
use Doctrine\ORM\EntityManager;
use Fichier\Service\Fichier\FichierService;
use Interop\Container\Containerinterface;
use UnicaenAuthentification\Service\UserContext;
use UnicaenMail\Service\Mail\MailService;
use UnicaenRenderer\Service\Rendu\RenduService;

class StepServiceFactory {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $serviceProvider = new StepService();

//        /** @var UserContext $userContext */
//        $userContext = $container->get('authUserContext');
//        $serviceProvider->setUserContext($userContext);

//        /** @var EntityManager $entityManager */
//        $entityManager = $container->get(EntityManager::class);
//        $serviceProvider->setEntityManager($entityManager);

//        /** @var UserContext $userContext */
        $stepMessageService = $container->get(StepMessageService::class);
        $serviceProvider->setStepMessageService($stepMessageService);

        $fichierService = $container->get(FichierService::class);
        $serviceProvider->setFichierService($fichierService);

        $documentService = $container->get(DocumentService::class);
        $serviceProvider->setDocumentService($documentService);

        $mailService = $container->get(MailService::class);
        $serviceProvider->setMailService($mailService);

        $renduService = $container->get(RenduService::class);
        $serviceProvider->setRenduService($renduService);

        return $serviceProvider;
    }
}