<?php


namespace Application\Application\Form\Formation\Factory;

use Application\Application\Form\Formation\TypeDiplomeForm;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\HelperPluginManager;

/**
 * Class TypeDiplomeFormFactory
 */
class TypeDiplomeFormFactory implements FactoryInterface
{
    /**
     * Create fieldset
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return TypeDiplomeForm|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var TypeDiplomeForm $form */
        $form = new TypeDiplomeForm();

        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        $form->setEntityManager($entityManager);

        /** @var HelperPluginManager $viewHelperManager */
        $viewHelperManager = $container->get("ViewHelperManager");
        $form->setViewHelperManager($viewHelperManager);

        return $form;
    }
}