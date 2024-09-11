<?php

namespace Application\Application\Service\Formation;

use Adapter\Service\Interfaces\ComposanteEntityAdapterServiceInterface;
use Adapter\Service\Interfaces\FormationEntityAdapterServiceInterface;
use Adapter\Service\Interfaces\TypeFormationEntityAdapterServiceInterface;
use Adapter\Service\PickYourCourses\PycComposanteService;
use Adapter\Service\PickYourCourses\PycFormationService;
use Adapter\Service\PickYourCourses\PycTypeFormationService;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use UnicaenAuthentification\Service\UserContext;

/**
 * Class TypeFormationServiceFactory
 * @package Application\Application\Service\Formation
 */
class TypeFormationServiceFactory implements FactoryInterface
{

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return TypeFormationService|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var TypeFormationService $serviceProvider */
        $serviceProvider = new TypeFormationService();

        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        $serviceProvider->setEntityManager($entityManager);

        return $serviceProvider;
    }
}