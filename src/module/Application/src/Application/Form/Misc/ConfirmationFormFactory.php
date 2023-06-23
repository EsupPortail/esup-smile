<?php


namespace Application\Application\Form\Misc;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\HelperPluginManager;

/**
 * Class ConfirmationFormFactory
 * @package Application\Application\Form\Misc
 */
class ConfirmationFormFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return ConfirmationForm|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ConfirmationForm $form */
        $form = new ConfirmationForm();

        /** @var HelperPluginManager $viewHelperManager */
        $viewHelperManager = $container->get("ViewHelperManager");
        $form->setViewHelperManager($viewHelperManager);

        return $form;
    }
}