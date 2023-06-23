<?php


namespace Application\Application\View\Helper\Composante;

use Application\Application\Validator\Actions\ComposanteActionsValidator;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Validator\ValidatorPluginManager;

/**
 * Class ComposanteViewHelperFactory
 * @package Application\Application\View\Helper\Composante;
 */
class ComposanteViewHelperFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return ComposanteViewHelper
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /**
         * @var ComposanteViewHelper $vh
         */
        $vh = new ComposanteViewHelper();

        /** @var ComposanteActionsValidator */
        $actionValidator = $container->get(ValidatorPluginManager::class)->get(ComposanteActionsValidator::class);
        $vh->setActionsValidator($actionValidator);

        return $vh;
    }

}