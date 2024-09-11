<?php


namespace Application\Application\Form\Formation\Factory;

use Application\Application\Form\Formation\TypeFormationForm;
use Application\Application\Form\Formation\TypeFormationHydrator;
use Doctrine\Laminas\Hydrator\DoctrineObject;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\HelperPluginManager;

/**
 * Class TypeFormationHydratorFactory
 */
class TypeFormationHydratorFactory implements FactoryInterface
{
    /**
     * Create fieldset
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return TypeFormationHydrator
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var TypeFormationHydrator $hydrator */
        $hydrator = new TypeFormationHydrator();

        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        $hydrator->setEntityManager($entityManager);

        return $hydrator;
    }
}