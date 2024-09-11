<?php

namespace Application\Application\Service\Cours;

use Application\Application\Service\Formation\FormationService;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use UnicaenAuthentification\Service\UserContext;

/**
 * Class CoursServiceFactory
 * @package Application\Application\Service\Cours
 */
class CoursServiceFactory implements FactoryInterface
{

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return CoursService|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var CoursService $serviceProvider */
        $serviceProvider = new CoursService();

        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        $serviceProvider->setEntityManager($entityManager);

        /** @var UserContext $userContext */
        $userContext = $container->get('authUserContext');
        $serviceProvider->setUserContext($userContext);

        /** @var FormationService $entityService */
        $entityService = $container->get('ServiceManager')->get(FormationService::class);
        $serviceProvider->setFormationService($entityService);

        return $serviceProvider;
    }
}