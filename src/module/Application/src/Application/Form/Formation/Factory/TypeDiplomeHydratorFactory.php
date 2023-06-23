<?php


namespace Application\Application\Form\Formation\Factory;

use Application\Application\Form\Formation\TypeDiplomeHydrator;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class TypeDiplomeHydratorFactory
 */
class TypeDiplomeHydratorFactory implements FactoryInterface
{
    /**
     * Create fieldset
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return TypeDiplomeHydrator
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var TypeDiplomeHydrator $hydrator */
        $hydrator = new TypeDiplomeHydrator();

        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        $hydrator->setEntityManager($entityManager);

        return $hydrator;
    }
}