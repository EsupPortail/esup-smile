<?php


namespace Application\Application\Form\Inscription\Factory;

use Application\Form\Inscription\InscriptionForm;
use Application\Form\Inscription\InscriptionHydrator;
use Doctrine\Laminas\Hydrator\DoctrineObject;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\HelperPluginManager;

/**
 * Class InscriptionHydratorFactory
 */
class InscriptionHydratorFactory implements FactoryInterface
{
    /**
     * Create fieldset
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return InscriptionHydrator
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var InscriptionHydrator $hydrator */
        $hydrator = new InscriptionHydrator();

        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        $hydrator->setEntityManager($entityManager);

        return $hydrator;
    }
}