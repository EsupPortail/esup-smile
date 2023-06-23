<?php


namespace Application\Application\Form\Formation\Factory;

use Application\Application\Form\Formation\FormationForm;
use Application\Application\Form\Formation\FormationHydrator;
use Doctrine\Laminas\Hydrator\DoctrineObject;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\HelperPluginManager;

/**
 * Class FormationHydratorFactory
 */
class FormationHydratorFactory implements FactoryInterface
{
    /**
     * Create fieldset
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return FormationHydrator
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var FormationHydrator $hydrator */
        $hydrator = new FormationHydrator();

        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        $hydrator->setEntityManager($entityManager);

        return $hydrator;
    }
}