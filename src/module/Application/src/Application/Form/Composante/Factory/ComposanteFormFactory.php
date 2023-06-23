<?php


namespace Application\Application\Form\Composante\Factory;

use Application\Application\Form\Composante\ComposanteForm;
use Doctrine\Laminas\Hydrator\DoctrineObject;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\HelperPluginManager;

/**
 * Class ComposanteFormFactory
 */
class ComposanteFormFactory implements FactoryInterface
{
    /**
     * Create fieldset
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return ComposanteForm|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ComposanteForm $form */
        $form = new ComposanteForm();

        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        $form->setEntityManager($entityManager);


        /** @var HelperPluginManager $viewHelperManager */
        $viewHelperManager = $container->get("ViewHelperManager");
        $form->setViewHelperManager($viewHelperManager);

        /** @var DoctrineObject $hydrator */
        $hydrator = $container->get("HydratorManager")->get(DoctrineObject::class);
        $form->setHydrator($hydrator);

        return $form;
    }
}