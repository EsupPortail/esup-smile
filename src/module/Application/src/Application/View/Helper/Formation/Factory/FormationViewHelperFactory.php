<?php


namespace Application\Application\View\Helper\Formation\Factory;

use Application\Application\Validator\Actions\FormationActionsValidator;
use Application\Application\View\Helper\Formation\FormationViewHelper;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Validator\ValidatorPluginManager;

/**
 * Class FormationViewHelperFactory
 * @package Application\Application\View\Helper\Composante;
 */
class FormationViewHelperFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return FormationViewHelper
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /**
         * @var FormationViewHelper $vh
         */
        $vh = new FormationViewHelper();

        /** @var FormationActionsValidator */
        $actionValidator = $container->get(ValidatorPluginManager::class)->get(FormationActionsValidator::class);
        $vh->setActionsValidator($actionValidator);

        return $vh;
    }

}