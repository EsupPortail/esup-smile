<?php


namespace UnicaenUtilisateurLdapAdapter;

use Laminas\Mvc\ModuleRouteListener;
use Laminas\Mvc\MvcEvent;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Stdlib\Glob;
use Laminas\Config\Factory as ConfigFactory;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        /* Active un layout spécial si la requête est de type AJAX. Valable pour TOUS les modules de l'application. */
        $eventManager->getSharedManager()->attach('Laminas\Mvc\Controller\AbstractActionController', 'dispatch',
            function (MvcEvent $e) {
                $request = $e->getRequest();
                if ($request instanceof HttpRequest && $request->isXmlHttpRequest()) {
                    $e->getTarget()->layout('layout/ajax.phtml');
                }
            }
        );

    }

    public function getConfig()
    {
        $configInit = [
            __DIR__ . '/config/module.config.php'
        ];
        $configFiles = ArrayUtils::merge(
            $configInit,
            Glob::glob(__DIR__ . '/config/merged/{,*.}{config}.php', Glob::GLOB_BRACE)
        );

        return ConfigFactory::fromFiles($configFiles);
    }


    public function getAutoloaderConfig()
    {
        return array(
            'Laminas\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
