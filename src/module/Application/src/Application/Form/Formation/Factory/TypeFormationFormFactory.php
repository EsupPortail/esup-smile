<?php


namespace Application\Application\Form\Formation\Factory;

use Application\Application\Form\Formation\TypeFormationForm;
use Doctrine\Laminas\Hydrator\DoctrineObject;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\HelperPluginManager;

/**
 * Class TypeFormationFormFactory
 */
class TypeFormationFormFactory implements FactoryInterface
{
    /**
     * Create fieldset
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return TypeFormationForm|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var TypeFormationForm $form */
        $form = new TypeFormationForm();

        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        $form->setEntityManager($entityManager);

        /** @var HelperPluginManager $viewHelperManager */
        $viewHelperManager = $container->get("ViewHelperManager");
        $form->setViewHelperManager($viewHelperManager);

        return $form;
    }
}