<?php


namespace Application\Application\View\Helper\Formation\Factory;

use Application\Application\Validator\Actions\FormationActionsValidator;
use Application\Application\Validator\Actions\TypeFormationActionsValidator;
use Application\Application\View\Helper\Formation\TypeFormationViewHelper;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Validator\ValidatorPluginManager;

/**
 * Class TypeFormationViewHelperFactory
 * @package Application\Application\View\Helper\Composante;
 */
class TypeFormationViewHelperFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return TypeFormationViewHelper
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /**
         * @var TypeFormationViewHelper $vh
         */
        $vh = new TypeFormationViewHelper();

        /** @var TypeFormationActionsValidator */
        $actionValidator = $container->get(ValidatorPluginManager::class)->get(TypeFormationActionsValidator::class);
        $vh->setActionsValidator($actionValidator);

        return $vh;
    }

}