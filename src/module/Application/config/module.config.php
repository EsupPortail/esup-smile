<?php

namespace Application;

use Application\Controller\IndexController;
use Application\Controller\IndexControllerFactory;
use Doctrine\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Laminas\Navigation\Navigation;
use Laminas\Navigation\Service\ConstructedNavigationFactory;
use Laminas\Router\Http\Segment;
use UnicaenApp\Controller\CacheControllerFactory;
use UnicaenApp\Controller\ConsoleController;
use UnicaenApp\Controller\ConsoleControllerFactory;
use UnicaenApp\Controller\InstadiaControllerFactory;
use UnicaenApp\Form\View\Helper\FormControlGroup;
use UnicaenApp\Form\View\Helper\FormControlGroupFactory;
use UnicaenApp\HostLocalization\HostLocalization;
use UnicaenApp\HostLocalization\HostLocalizationFactory;
use UnicaenApp\Message\View\Helper\MessageHelper;
use UnicaenApp\Message\View\Helper\MessageHelperFactory;
use UnicaenApp\Mvc\RedirectResponse;
use UnicaenApp\Mvc\RedirectResponseFactory;
use UnicaenApp\ORM\Query\Functions\Chr;
use UnicaenApp\ORM\Query\Functions\CompriseEntre;
use UnicaenApp\ORM\Query\Functions\PasHistorise;
use UnicaenApp\ORM\Query\Functions\Replace;
use UnicaenApp\Service\InstadiaServiceFactory;
use UnicaenApp\Service\Mailer\MailerService;
use UnicaenApp\Service\Mailer\MailerServiceFactory;
use UnicaenApp\Service\SQL\RunSQLService;
use UnicaenApp\Service\SQL\RunSQLServiceFactory;
use UnicaenApp\ServiceManager\ServiceLocatorAwareInitializer;
use UnicaenApp\View\Helper\AppInfos;
use UnicaenApp\View\Helper\AppInfosFactory;
use UnicaenApp\View\Helper\AppLink;
use UnicaenApp\View\Helper\AppLinkFactory;
use UnicaenApp\View\Helper\HeadLink;
use UnicaenApp\View\Helper\HeadLinkFactory;
use UnicaenApp\View\Helper\HeadScript;
use UnicaenApp\View\Helper\HeadScriptFactory;
use UnicaenApp\View\Helper\InlineScript;
use UnicaenApp\View\Helper\InlineScriptFactory;
use UnicaenApp\View\Helper\InstadiaViewHelper;
use UnicaenApp\View\Helper\InstadiaViewHelperFactory;
use UnicaenApp\View\Helper\MessageCollectorHelper;
use UnicaenApp\View\Helper\MessageCollectorHelperFactory;
use UnicaenApp\View\Helper\Messenger;
use UnicaenApp\View\Helper\MessengerFactory;
use UnicaenApp\View\Helper\QueryParams;
use UnicaenApp\View\Helper\QueryParamsHelperFactory;
use UnicaenApp\View\Helper\Upload\UploaderHelper;
use UnicaenApp\View\Helper\Upload\UploaderHelperFactory;
use UnicaenApp\View\Helper\UserProfileSelect;
use UnicaenApp\View\Helper\UserProfileSelectFactory;
#use Laminas\Mvc\Console\Router\Simple; ## Fix Romain A
use UnicaenPrivilege\Guard\PrivilegeController;

return [
    'bjyauthorize' => [
        'guards' => [
            PrivilegeController::class => [
                [
                    'controller' => IndexController::class,
                    'action' => [
                        'index',
                    ],
                ],
                [
                    'controller' => IndexController::class,
                    'action' => [
                        'language',
                    ]
                ],
            ],
        ],
    ],
    'router' => [
        'routes' => [
            // Base “route”, which describes the base match needed, the root of the tree
            'home'             => [
                // The Literal route is for doing exact matching of the URI path
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'index',
                    ],
                ],
                'flash-message' => [
                    'type' => 'Literal',
                    'options' => [
                        'route' => '/flash-message',
                        'defaults' => [
                            'controller' => IndexController::class,
                            'action' => 'flash-message',
                        ],
                    ],
                ],
            ],
            'language' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/language/[:locale]',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action' => 'language',
                    ],
                ],
            ],
            // A propos
            'apropos'          => [
                'type'     => 'Literal',
                'options'  => [
                    'route'    => '/apropos',
                    'defaults' => [
                        'controller' => 'UnicaenApp\Controller\Application',
                        'action'     => 'apropos',
                    ],
                ],
                'priority' => 9999,
            ],
            // Contact
            'contact'          => [
                'type'     => 'Literal',
                'options'  => [
                    'route'    => '/contact',
                    'defaults' => [
                        'controller' => 'UnicaenApp\Controller\Application',
                        'action'     => 'contact',
                    ],
                ],
                'priority' => 9999,
            ],
            // Plan de navigation
            'plan'             => [
                'type'     => 'Literal',
                'options'  => [
                    'route'    => '/plan',
                    'defaults' => [
                        'controller' => 'UnicaenApp\Controller\Application',
                        'action'     => 'plan',
                    ],
                ],
                'priority' => 9999,
                'visible' => false,
            ],
            // Mentions légales
            'mentions-legales' => [
                'type'     => 'Literal',
                'options'  => [
                    'route'    => '/mentions-legales',
                    'defaults' => [
                        'controller' => 'UnicaenApp\Controller\Application',
                        'action'     => 'mentions-legales',
                    ],
                ],
                'priority' => 9999,
            ],
            // Informatique et libertés
            'il'               => [
                'type'     => 'Literal',
                'options'  => [
                    'route'    => '/informatique-et-libertes',
                    'defaults' => [
                        'controller' => 'UnicaenApp\Controller\Application',
                        'action'     => 'informatique-et-libertes',
                    ],
                ],
                'priority' => 9999,
            ],
            // Rafraîchissement de la session
            'refresh-session'  => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/refresh-session',
                    'defaults' => [
                        'controller' => 'UnicaenApp\Controller\Application',
                        'action'     => 'refresh-session',
                    ],
                ],
            ],
            //            // Rendu du menu secondaire
            //            'menu-secondaire' => [
            //                'type'          => 'Literal',
            //                'options'       => [
            //                    'route'       => '/menu-secondaire',
            //                    'defaults'    => [
            //                        'controller' => 'UnicaenApp\Controller\Application',
            //                        'action'     => 'menu-secondaire',
            //                    ],
            //                ],
            //            ],
            // Test d'envoi de mail par l'appli
            'test-envoi-mail'  => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/test-envoi-mail',
                    'defaults' => [
                        'controller' => 'UnicaenApp\Controller\Application',
                        'action'     => 'test-envoi-mail',
                    ],
                ],
            ],
            'maintenance'      => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/maintenance',
                    'defaults' => [
                        'controller' => 'UnicaenApp\Controller\Application',
                        'action'     => 'maintenance',
                    ],
                ],
            ],
            // Icônes fournis
            'icons'          => [
                'type'     => 'Literal',
                'options'  => [
                    'route'    => '/icons',
                    'defaults' => [
                        'controller' => 'UnicaenApp\Controller\Application',
                        'action'     => 'icons',
                    ],
                ],
            ],
            'cache'            => [
                'type'          => 'Literal',
                'options'       => [
                    'route'    => '/cache',
                    'defaults' => [
                        'controller' => 'UnicaenApp\Controller\Cache',
                    ],
                ],
                'may_terminate' => false,
                'child_routes'  => [
                    'js'  => [
                        'type'          => 'Segment',
                        'options'       => [
                            'route'    => '/js[/:version]',
                            'defaults' => [
                                'action' => 'js',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'css' => [
                        'type'          => 'Segment',
                        'options'       => [
                            'route'    => '/css[/:version]',
                            'defaults' => [
                                'action' => 'css',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                ],
            ],
            'instadia'         => [
                'type'          => 'Literal',
                'options'       => [
                    'route'    => '/instadia',
                    'defaults' => [
                        '__NAMESPACE__' => 'UnicaenApp\Controller',
                        'controller'    => 'Instadia',
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
            ],
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application'      => [
                // The Literal route is for doing exact matching of the URI path
                'type'          => 'Literal',
                'options'       => [
                    'route'    => '/application',
                    'defaults' => [
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ],
                ],
                // Hints to the router that no other segments will follow it
                'may_terminate' => true,
                // Additional routes that stem from the base “route” (i.e., build from it)
                'child_routes'  => [
                    'default' => [
                        // A Segment route allows matching any segment of a URI path
                        'type'    => 'Segment',
                        'options' => [
                            'route'       => '/[:controller[/:action]]',
                            'constraints' => [
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults'    => [
//                                'action' => 'index',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'console'         => [
        'router'       => [
            'routes' => [
                'run-sql-script' => [
                    'type'    => "Simple",
                    'options' => [
                        'route'    => 'run-sql-script --path= [--logfile=] [--connection=]',
                        'defaults' => [
                            'controller' => ConsoleController::class,
                            'action'     => 'runSQLScript',
                        ],
                    ],
                ],
                'run-sql-query'  => [
                    'type'    => "Simple",
                    'options' => [
                        'route'    => 'run-sql-query --sql= [--logfile=] [--connection=]',
                        'defaults' => [
                            'controller' => ConsoleController::class,
                            'action'     => 'runSQLQuery',
                        ],
                    ],
                ],
            ],
        ],
        'view_manager' => [
            'display_not_found_reason' => true,
            'display_exceptions'       => true,
        ],
    ],
    'service_manager' => [
        'factories'          => [
            'translator'                  => 'Laminas\I18n\Translator\TranslatorServiceFactory',
//            'navigation'                  => 'Laminas\Navigation\Service\DefaultNavigationFactory',
            // service de gestion de la session
            'Laminas\Session\SessionManager' => 'UnicaenApp\Session\SessionManagerFactory',
            // service d'accès aux options de config de ce module
            'unicaen-app_module_options'  => 'UnicaenApp\Options\ModuleOptionsFactory',
            // mapper d'accès aux individus de l'annuaire LDAP
            'ldap_people_mapper'          => 'UnicaenApp\Mapper\Ldap\PeopleFactory',
            // mapper d'accès aux groupes de l'annuaire LDAP
            'ldap_group_mapper'           => 'UnicaenApp\Mapper\Ldap\GroupFactory',
            // mapper d'accès aux structures de l'annuaire LDAP
            'ldap_structure_mapper'       => 'UnicaenApp\Mapper\Ldap\StructureFactory',
            // service de manipulation des individus de l'annuaire LDAP
            'ldap_people_service'         => 'UnicaenApp\Service\Ldap\PeopleFactory',
            // service de manipulation des groupes de l'annuaire LDAP
            'ldap_group_service'          => 'UnicaenApp\Service\Ldap\GroupFactory',
            // service de manipulation des structures de l'annuaire LDAP
            'ldap_structure_service'      => 'UnicaenApp\Service\Ldap\StructureFactory',

            // Gestion des CSV
            'ViewCsvRenderer'             => 'UnicaenApp\Mvc\Service\ViewCsvRendererFactory',
            'ViewCsvStrategy'             => 'UnicaenApp\Mvc\Service\ViewCsvStrategyFactory',

            // Gestion des exports XML
            'ViewXmlRenderer'             => 'UnicaenApp\Mvc\Service\ViewXmlRendererFactory',
            'ViewXmlStrategy'             => 'UnicaenApp\Mvc\Service\ViewXmlStrategyFactory',

            'MessageCollector' => 'UnicaenApp\Service\MessageCollectorFactory',

            'MessageConfig'     => 'UnicaenApp\Message\MessageConfigFactory',
            'MessageRepository' => 'UnicaenApp\Message\MessageRepositoryFactory',
            'MessageService'    => 'UnicaenApp\Message\MessageServiceFactory',

            'MouchardService'              => 'UnicaenApp\Mouchard\MouchardServiceFactory',
            'MouchardListenerErrorHandler' => 'UnicaenApp\Mouchard\MouchardListenerErrorHandlerFactory',
            'MouchardListenerException'    => 'UnicaenApp\Mouchard\MouchardListenerExceptionFactory',
            'MouchardListenerMessenger'    => 'UnicaenApp\Mouchard\MouchardListenerMessengerFactory',
            'MouchardFormaterHtml'         => 'UnicaenApp\Mouchard\MouchardFormaterHtmlFactory',
            'MouchardSenderMail'           => 'UnicaenApp\Mouchard\MouchardSenderMailFactory',
            'MouchardSenderException'      => 'UnicaenApp\Mouchard\MouchardSenderExceptionFactory',
            'MouchardCompleterHttp'        => 'UnicaenApp\Mouchard\MouchardCompleterHttpFactory',
            'MouchardCompleterMvc'         => 'UnicaenApp\Mouchard\MouchardCompleterMvcFactory',

            MailerService::class    => MailerServiceFactory::class,
            RunSQLService::class    => RunSQLServiceFactory::class,
            'instadia'              => InstadiaServiceFactory::class,
            HostLocalization::class => HostLocalizationFactory::class,
            RedirectResponse::class => RedirectResponseFactory::class,
        ],
        'shared'             => [
            'MouchardListenerErrorHandler' => false,
            'MouchardListenerException'    => false,
            'MouchardListenerMessenger'    => false,
            'MouchardFormaterHtml'         => false,
            'MouchardSenderMail'           => false,
            'MouchardSenderException'      => false,
            'MouchardCompleterHttp'        => false,
            'MouchardCompleterMvc'         => false,
        ],
        'invokables'         => [
        ],
        'abstract_factories' => [
//            'UnicaenApp\Service\Doctrine\MultipleDbAbstractFactory',
        ],
        'initializers'       => [
            ServiceLocatorAwareInitializer::class,
            'UnicaenApp\Service\EntityManagerAwareInitializer',
        ],
        'aliases'            => [
            'MailerService'    => MailerService::class,
            'HostLocalization' => HostLocalization::class,
        ],
    ],
    'form_elements'   => [
        'invokables'   => [
            'UploadForm' => 'UnicaenApp\Controller\Plugin\Upload\UploadForm',
        ],
        'initializers' => [
            'UnicaenApp\Service\EntityManagerAwareInitializer',
        ],
    ],
    'hydrators'       => [
        'initializers' => [
            'UnicaenApp\Service\EntityManagerAwareInitializer',
        ],
    ],
    'view_helpers'   => [
        'shared'       => [
            'formControlGroup' => false,
        ],
//        'aliases'      => [
//            'appInfos'          => AppInfos::class,
//            'appLink'           => AppLink::class,
//            'userProfileSelect' => UserProfileSelect::class,
//            'Message'           => MessageHelper::class,
//            'message'           => MessageHelper::class,
//            'messenger'         => Messenger::class,
//            'queryParams'       => QueryParams::class,
//            'formControlGroup'  => FormControlGroup::class,
//            'headLink'          => HeadLink::class,
//            'headScript'        => HeadScript::class,
//            'inlineScript'      => InlineScript::class,
//            'instadia'          => InstadiaViewHelper::class,
//            'messageCollector'  => MessageCollectorHelper::class,
//            'uploader'          => UploaderHelper::class,
//            'Uploader'          => UploaderHelper::class,
//        ],
//        'factories'    => [
//            AppInfos::class               => AppInfosFactory::class,
//            AppLink::class                => AppLinkFactory::class,
//            UserProfileSelect::class      => UserProfileSelectFactory::class,
//            MessageHelper::class          => MessageHelperFactory::class,
//            Messenger::class              => MessengerFactory::class,
//            QueryParams::class            => QueryParamsHelperFactory::class,
//            FormControlGroup::class       => FormControlGroupFactory::class,
//            HeadLink::class               => HeadLinkFactory::class,
//            HeadScript::class             => HeadScriptFactory::class,
//            InlineScript::class           => InlineScriptFactory::class,
//            InstadiaViewHelper::class     => InstadiaViewHelperFactory::class,
//            MessageCollectorHelper::class => MessageCollectorHelperFactory::class,
//            UploaderHelper::class         => UploaderHelperFactory::class,
//        ],
//        'invokables'   => [
//            'appConnection'             => 'UnicaenApp\View\Helper\AppConnection',
//            'modalAjaxDialog'           => 'UnicaenApp\View\Helper\ModalAjaxDialog',
//            'confirm'                   => 'UnicaenApp\View\Helper\ConfirmHelper',
//            'toggleDetails'             => 'UnicaenApp\View\Helper\ToggleDetails',
//            'multipageFormFieldset'     => 'UnicaenApp\Form\View\Helper\MultipageFormFieldset',
//            'multipageFormNav'          => 'UnicaenApp\Form\View\Helper\MultipageFormNav',
//            'multipageFormRow'          => 'UnicaenApp\Form\View\Helper\MultipageFormRow',
//            'multipageFormRecap'        => 'UnicaenApp\Form\View\Helper\MultipageFormRecap',
//            'formDate'                  => 'UnicaenApp\Form\View\Helper\FormDate',
//            'formDateTime'              => Form\View\Helper\FormDateTime::class,
//            'formDateInfSup'            => 'UnicaenApp\Form\View\Helper\FormDateInfSup',
//            'formRowDateInfSup'         => 'UnicaenApp\Form\View\Helper\FormRowDateInfSup',
//            'formSearchAndSelect'       => 'UnicaenApp\Form\View\Helper\FormSearchAndSelect',
//            'formLdapPeople'            => 'UnicaenApp\Form\View\Helper\FormLdapPeople',
//            'formErrors'                => 'UnicaenApp\Form\View\Helper\FormErrors',
//            'form'                      => 'UnicaenApp\Form\View\Helper\Form',
//            'formAdvancedMultiCheckbox' => 'UnicaenApp\Form\View\Helper\FormAdvancedMultiCheckbox',
//            'historique'                => 'UnicaenApp\View\Helper\HistoriqueViewHelper',
//            'tabajax'                   => 'UnicaenApp\View\Helper\TabAjax\TabAjaxViewHelper',
//            'tag'                       => 'UnicaenApp\View\Helper\TagViewHelper',
//        ],
    ],
    'translator'      => [
        'translation_file_patterns' => [
            [
                'type'     => 'phparray',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '/%s/Zend_Captcha.php',
            ],
            [
                'type'     => 'phparray',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '/%s/Zend_Validate.php',
            ],
            [
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ],
        ],
    ],
    'controllers'     => [
        'invokables'   => [
            'UnicaenApp\Controller\Application' => 'UnicaenApp\Controller\ApplicationController',
        ],
        'initializers' => [
            'UnicaenApp\Service\EntityManagerAwareInitializer',
        ],
        'factories'    => [
            IndexController::class => IndexControllerFactory::class,
            'UnicaenApp\Controller\Cache'    => CacheControllerFactory::class,
            'UnicaenApp\Controller\Instadia' => InstadiaControllerFactory::class,
            ConsoleController::class         => ConsoleControllerFactory::class,
        ],
    ],

    'doctrine' => [
        'driver' => [
            'orm_default' => [
                'class' => MappingDriverChain::class,
                'drivers' => [
                    'Application\Entity' => 'orm_default_xml_driver',
                ],
            ],
            'orm_default_xml_driver' => [
                'class' => XmlDriver::class,
                'cache' => 'apc',
                'paths' => [
                    __DIR__ . '/../src/Application/Entity/Mapping',
                ],
            ],
        ],
        'cache' => [
            'apc' => [
                'namespace' => 'SMILE__' . __NAMESPACE__,
            ],
        ],
//        'configuration' => [
//            'orm_default' => [
//                'string_functions' => [
//                    'compriseEntre' => CompriseEntre::class,
//                    'pasHistorise' => PasHistorise::class,
//                    'replace' => Replace::class,
//                    'chr' => Chr::class,
//                ],
//            ],
//        ],
    ],

    'view_manager' => [
        // RouteNotFoundStrategy configuration
        'display_not_found_reason' => true, // display 404 reason in template
//        'not_found_template'       => 'error/404', // e.g. '404'
        // ExceptionStrategy configuration
        'display_exceptions'       => true,
//        'exception_template'       => 'error/index',
        // Doctype with which to seed the Doctype helper
        'doctype'                  => 'HTML5',
        // TemplateMapResolver configuration
        // template/path pairs
        'template_map'             => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
//            'error/404'     => __DIR__ . '/../view/error/404.phtml',
//            'error/index'   => __DIR__ . '/../view/error/index.phtml',
            //            'unicaen-app/application/apropos'                  => __DIR__ . '/../view/application/apropos.phtml',
            //            'unicaen-app/application/contact'                  => __DIR__ . '/../view/application/contact.phtml',
            //            'unicaen-app/application/plan'                     => __DIR__ . '/../view/application/plan.phtml',
            //            'unicaen-app/application/mentions-legales'         => __DIR__ . '/../view/application/mentions-legales.phtml',
            //            'unicaen-app/application/informatique-et-libertes' => __DIR__ . '/../view/application/informatique-et-libertes.phtml',
        ],
        // TemplatePathStack configuration
        'template_path_stack'      => [
            __DIR__ . '/../view',
        ],
        // Layout template name
        'layout'                   => 'layout/layout', // e.g., 'layout/layout'
        // Additional strategies to attach
        'strategies'               => [
            'ViewJsonStrategy', // register JSON renderer strategy
            'ViewCsvStrategy', // register CSV renderer strategy
            //            'ViewXmlStrategy', // register XML renderer strategy
            //            'ViewFeedStrategy', // register Feed renderer strategy
        ],
    ],

    /**
     * NB: Lors d'un `composer install` fait par une appli requérant le module "unicaen/app", le répertoire
     * `public/unicaen` de ce module doit être copié dans le répertoire "public/" de l'appli en question grâce
     * à la "post install command" suivante :
     *
     * "scripts": {
     *      "post-install-cmd": [
     *          "cp -r vendor/unicaen/app/public/unicaen public/"
     *      ]
     * }
     *
     * Les chemins ci-dessous sont donc relatifs au dossier racine de l'appli.
     */
    'public_files' => [
        'head_scripts'          => [
            '015_jquery' => 'unistrap-1.0.0/js/jquery-3.6.1.min.js',
            '040_bootstrap' => '',
        ],
        'inline_scripts' => [
            '020_app'         => '',
            '030_util'        => 'unicaen/app/js/util.js',
            '040_unicaen'     => 'unicaen/app/js/unicaen.js',
            '050_jquery_form' => '',
            '070_bootstrap' => 'unistrap-1.0.0/lib/bootstrap-5.2.2/dist/js/bootstrap.bundle.min.js',
            '080_unistrap' => 'unistrap-1.0.0/js/unistrap.js',
            '110_' => 'vendor/DataTables/datatables.min.js',
            '150_' => 'vendor/tinymce/js/tinymce/tinymce.js',
            '160_' => 'vendor/fontawesome-free-6.2.0-web/js/all.js',
//            '161_' => 'vendor/fontawesome-free-6.2.0-web/js/fontawesome.js',
        ],
        'stylesheets' => [
            '040_bootstrap' => 'unistrap-1.0.0/lib/bootstrap-5.2.2/dist/css/bootstrap.min.css',
            '041_ubuntu' => 'unistrap-1.0.0/css/font-ubuntu.css',
            '042_app' => 'css/app.css',
            '043_unistrap' => 'css/unistrap-smile.css',
//            '043_unistrap' => 'unistrap-1.0.0/css/unistrap.css',
            '060_unicaen'             => '',
            '110_' => 'vendor/DataTables/datatables.min.css',
            '112_' => 'vendor/fontawesome-free-6.2.0-web/css/all.min.css',
            '065_unicaen-icon'        => 'unicaen/app/css/unicaen-icon.css',
            '075_logos'        => 'css/logos.css',
            '085_modal'        => 'css/modal.css',
            '086_gestion'        => 'css/gestion.css',
            /** Smile styles */
            '501_dashboard' => 'css/dashboard.css',
        ],
        'printable_stylesheets' => [
        ],
        'cache_enabled'         => false,
    ],
//    'public_files' => [
//        'head_scripts'          => [
//            '015_jquery'   => 'unicaen/app/vendor/jquery-3.6.0.min.js',
////            '020_jqueryui' => '/unicaen/app/vendor/jquery-ui-1.12.1/jquery-ui.min.js',
////            '020_jqueryui' => '/unicaen/app/vendor/jquery-ui-1.13.2.custom/jquery-ui.min.js',
//            '020_jqueryui' => '/unistrap-1.0.0/lib/jquery-ui-1.13.2/jquery-ui.js',
//            '040_bootstrap' => '',
//        ],
//        'inline_scripts'        => [
//            '020_app'         => '/unicaen/app/js/app.js',
//            '030_util'        => '/unicaen/app/js/util.js',
//            '040_unicaen'     => '/unicaen/app/js/unicaen.js',
//            '050_jquery_form' => '/unicaen/app/vendor/jquery.form.min.js', // pour l'uploader Unicaen uniquement!!,
//            '0101_datatables' => 'vendor/DataTables/datatables.min.js',
//        ],
//        'stylesheets'           => [
////            '010_jquery-ui'           => '/unicaen/app/vendor/jquery-ui-1.12.1/jquery-ui.min.css',
////            '020_jqueryui' => '/unicaen/app/vendor/jquery-ui-1.13.2.custom/jquery-ui.min.css',
//            '020_jqueryui' => '/unistrap-1.0.0/lib/jquery-ui-1.13.2/jquery-ui.css',
//            '020_jquery-ui-structure' => '/unicaen/app/vendor/jquery-ui-1.12.1/jquery-ui.structure.min.css',
//            '030_jquery-ui-theme'     => '/unicaen/app/vendor/jquery-ui-1.12.1/jquery-ui.theme.min.css',
//            '040_bootstrap'           => 'unistrap-1.0.0/lib/bootstrap-5.2.2/dist/css/boostrap.css',
//            '060_unicaen'             => '/unicaen/app/css/unicaen.css',
//            '061_structure' => '/css/structure.css',
//            '065_unicaen-icon'        => '/unicaen/app/css/unicaen-icon.css',
//            '070_app'                 => '/css/app.css',
//            '201_fontawesome' => 'vendor/fontawesome-free-6.2.0-web/css/all.css',
//            /** Unistrap */
//            '202_police_ubuntu' => 'unistrap-1.0.0/css/font-ubuntu.css',
//            '210_unistrap' => 'unistrap-1.0.0/css/unistrap.css'
//        ],

];
