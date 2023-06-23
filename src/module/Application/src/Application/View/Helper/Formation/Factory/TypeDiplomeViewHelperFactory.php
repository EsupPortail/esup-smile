<?php


namespace Application\Application\View\Helper\Formation\Factory;

use Application\Application\Validator\Actions\TypeDiplomeActionsValidator;
use Application\Application\View\Helper\Formation\TypeDiplomeViewHelper;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Validator\ValidatorPluginManager;

/**
 * Class TypeDiplomeViewHelperFactory
 * @package Application\Application\View\Helper\Composante;
 */
class TypeDiplomeViewHelperFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return TypeDiplomeViewHelper
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /**
         * @var TypeDiplomeViewHelper $vh
         */
        $vh = new TypeDiplomeViewHelper();

        /** @var TypeDiplomeActionsValidator */
        $actionValidator = $container->get(ValidatorPluginManager::class)->get(TypeDiplomeActionsValidator::class);
        $vh->setActionsValidator($actionValidator);

        return $vh;
    }

}