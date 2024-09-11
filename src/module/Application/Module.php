<?php

namespace Application;

use Laminas\Config\Factory as ConfigFactory;
use Laminas\EventManager\EventInterface;
use Laminas\Http\Request as HttpRequest;
use Laminas\I18n\Translator\Translator;
use Laminas\Mvc\ModuleRouteListener;
use Laminas\Mvc\MvcEvent;
use Laminas\Session\Container;
use Laminas\Session\SessionManager;
use Laminas\Session\Validator\HttpUserAgent;
use Laminas\Session\Validator\RemoteAddr;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Stdlib\Glob;
use Locale;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $application = $e->getApplication();
        $serviceManager = $application->getServiceManager();

//        $translator = new Translator();
//        $translator->addTranslationFilePattern('gettext', __DIR__.'/language', '%s.mo');
//        $serviceManager->setService('translator', $translator);
        $session = new Container('user_session');
        $langue = $session->language;
        if(!$langue) {
            $langue = 'fr_FR';
        }
        $translator = $serviceManager->get('translator');
        $translator->enableEventManager();

        $translator->getEventManager()->attach(
            Translator::EVENT_MISSING_TRANSLATION,
            static function (EventInterface $event) {
                error_log($event->getName().': '.json_encode($event->getParams()));
                printf($event->getName().': '.json_encode($event->getParams()));
            }
        );

        $translator->setFallbackLocale($langue);
        $translator->setLocale($langue);
        Locale::setDefault($langue);

        $eventManager = $application->getEventManager();
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

//        $this->bootstrapSession($e);
    }

    public function bootstrapSession(MvcEvent $e)
    {
//        $cache = StorageFactory::factory([
//            'adapter' => [
//                'name' => 'memcached',
//                'options' => [
//                    'server' => '127.0.0.1',
//                ],
//            ],
//        ]);
//
//        $saveHandler = new Cache($cache);
//        $manager = new SessionManager();
//        $manager->setSaveHandler($saveHandler);

        $session = $e->getApplication()
            ->getServiceManager()
            ->get(SessionManager::class);
        $session->start();

        $container = new Container('initialized');

        if (isset($container->init)) {
            return;
        }

        $serviceManager = $e->getApplication()->getServiceManager();
        $request        = $serviceManager->get('Request');

        $session->regenerateId(true);
        $container->init          = 1;
        $container->remoteAddr    = $request->getServer()->get('REMOTE_ADDR');
        $container->httpUserAgent = $request->getServer()->get('HTTP_USER_AGENT');

        $config = $serviceManager->get('Config');
        if (! isset($config['session'])) {
            return;
        }

        $sessionConfig = $config['session'];

        if (! isset($sessionConfig['validators'])) {
            return;
        }

        $chain   = $session->getValidatorChain();

        foreach ($sessionConfig['validators'] as $validator) {
            switch ($validator) {
                case HttpUserAgent::class:
                    $validator = new $validator($container->httpUserAgent);
                    break;
                case RemoteAddr::class:
                    $validator  = new $validator($container->remoteAddr);
                    break;
                default:
                    $validator = new $validator();
                    break;
            }

            $chain->attach('session.validate', array($validator, 'isValid'));
        }
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
        return [
            'Laminas\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }
}
