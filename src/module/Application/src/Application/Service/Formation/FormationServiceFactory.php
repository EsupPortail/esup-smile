<?php

namespace Application\Application\Service\Formation;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use UnicaenAuthentification\Service\UserContext;

/**
 * Class FormationServiceFactory
 * @package Application\Application\Service\Formation
 */
class FormationServiceFactory implements FactoryInterface
{

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return FormationService|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var FormationService $serviceProvider */
        $serviceProvider = new FormationService();

        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        $serviceProvider->setEntityManager($entityManager);

        /** @var UserContext $userContext */
        $userContext = $container->get('authUserContext');
        $serviceProvider->setUserContext($userContext);

        return $serviceProvider;
    }
}