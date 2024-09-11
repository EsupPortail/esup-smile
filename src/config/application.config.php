<?php

$modules = [
    'Laminas\Cache',
    'Laminas\Filter',
    'Laminas\Form',
    'Laminas\Hydrator',
    'Laminas\I18n',
    'Laminas\InputFilter',
    'Laminas\Log',
    'Laminas\Mail',
    'Laminas\Mvc\I18n',
    'Laminas\Mvc\Plugin\FlashMessenger',
    'Laminas\Mvc\Plugin\Prg',
    'Laminas\Navigation',
    'Laminas\Paginator',
    'Laminas\Router',
    'Laminas\Session',
    'Laminas\Validator',
    'DoctrineModule',
    'DoctrineORMModule',
    'ZfcUser',
    'BjyAuthorize',
    'UnicaenApp',
    'UnicaenPrivilege',
    'UnicaenMail',
    'UnicaenPdf',
    'UnicaenRenderer',
    'UnicaenAuthentification',
    'UnicaenUtilisateur',
    'UnicaenEgracon',
    'UnicaenParametre',
    'UnicaenSynchro',
    'UnicaenVue',
    'Fichier',
    'Import',
    'Message',
    'Api',
    'Application',
];
// Charge les variables d'environnements du .env
$dotenv = new Symfony\Component\Dotenv\Dotenv();
$dotenv->load(__DIR__.'/../.env');

$applicationEnv = $_ENV['APPLICATION_ENV'] ?: 'production';
if ('development' === $applicationEnv) {
    /** Enleve les erreurs Deprecated (8.2) en attendant la mise à jour des librairies
     * TODO: A enlever
     */
    error_reporting(E_ALL ^ E_DEPRECATED);
    $modules[] = 'Laminas\DeveloperTools';
}else {
    error_reporting(E_ERROR);
}

$moduleListenerOptions = [
    'config_glob_paths'    => [
        'config/autoload/{,*.}{global,local}.php',
    ],
    'module_paths' => [
        './module',
        './vendor',
    ],
    //Caches de la configurations uniquement en prod
    'config_cache_enabled' => ($applicationEnv === 'production'),
    'config_cache_key' => 'smile_config',
    'module_map_cache_enabled' => ($applicationEnv === 'production'),
    'module_map_cache_key' => 'smile_module',
    'cache_dir' => 'data/cache/',
    'check_dependencies'        => ($applicationEnv !== 'production'),
];

return [
    'modules' => $modules,
    'module_listener_options' => $moduleListenerOptions,
];
