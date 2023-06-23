<?php


namespace Application\Application\View\Helper\ShibConnect\Factory;


use Application\Application\View\Helper\ShibConnect\ShibConnectViewHelper;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use UnicaenAuthentification\Options\ModuleOptions;


class ShibConnectViewHelperFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $container->get('unicaen-auth_module_options');
        $config = $moduleOptions->getShib();


        $enabled = isset($config['enabled']) && (bool) $config['enabled'];
        $title = $config['title'] ?? null;
        $description = $config['description'] ?? null;


        $helper = new ShibConnectViewHelper();
        $helper->setEnabled($enabled);
        $helper->setTitle($title ?? ShibConnectViewHelper::TITLE);
        $helper->setDescription($description);


        return $helper;
    }
}
