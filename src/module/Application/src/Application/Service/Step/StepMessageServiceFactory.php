<?php

namespace Application\Service\Step;

use Doctrine\ORM\EntityManager;
use Interop\Container\Containerinterface;
use UnicaenAuthentification\Service\UserContext;

class StepMessageServiceFactory {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $serviceProvider = new StepMessageService();

//        /** @var UserContext $userContext */
//        $userContext = $container->get('authUserContext');
//        $serviceProvider->setUserContext($userContext);

//        /** @var EntityManager $entityManager */
//        $entityManager = $container->get(EntityManager::class);
//        $serviceProvider->setEntityManager($entityManager);


        return $serviceProvider;
    }
}