<?php


namespace Application\Application\View\Helper\Parametre\Factory;


use Application\Application\View\Helper\Parametre\ParametreViewHelper;
use Application\Service\Step\StepService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\Factory\FactoryInterface;
use UnicaenAuthentification\Options\ModuleOptions;
use UnicaenParametre\Service\Parametre\ParametreService;


class ParametreViewHelperFactory
{
    public function __invoke($container)
    {

        $helper = new ParametreViewHelper();

        if (! $container instanceof AbstractPluginManager) {
            // laminas-servicemanager v3. v2 passes the helper manager directly.
//            $container = $container->get('ViewHelperManager');
        }

        $parametreService = $container->get('ServiceManager')->get(ParametreService::class);
        $helper->setParametreService($parametreService);


        return $helper;
    }
}
