<?php


namespace Application\Application\View\Helper\Source;

use Application\Application\Validator\Actions\ComposanteActionsValidator;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Validator\ValidatorPluginManager;

/**
 * Class SourceViewHelperFactory
 * @package Application\Application\View\Helper\Composante;
 */
class SourceViewHelperFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return SourceViewHelper
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /**
         * @var SourceViewHelper $vh
         */
        $vh = new SourceViewHelper();
        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        $vh->setEntityManager($entityManager);
        return $vh;
    }

}