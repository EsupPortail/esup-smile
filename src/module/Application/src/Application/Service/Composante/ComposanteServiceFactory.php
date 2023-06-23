<?php

namespace Application\Application\Service\Composante;

use Adapter\Service\Interfaces\ComposanteEntityAdapterServiceInterface;
use Adapter\Service\PickYourCourses\PycComposanteService;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use UnicaenAuthentification\Service\UserContext;

/**
 * Class ComposanteServiceFactory
 * @package Application\Application\Service\Composante
 */
class ComposanteServiceFactory implements FactoryInterface
{

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return ComposanteService|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ComposanteService $serviceProvider */
        $serviceProvider = new ComposanteService();

        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        $serviceProvider->setEntityManager($entityManager);

        /** @var UserContext $userContext */
        $userContext = $container->get('authUserContext');
        $serviceProvider->setUserContext($userContext);

        return $serviceProvider;
    }
}