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
//    'Laminas\Mvc\Plugin\FilePrg',
    'Laminas\Mvc\Plugin\FlashMessenger',
//    'Laminas\Mvc\Plugin\Identity',
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
    'UnicaenLdap',
    'UnicaenPrivilege',
    'UnicaenMail',
    'UnicaenPdf',
    'UnicaenRenderer',
    'UnicaenEvenement',
    'UnicaenAuthentification',
    'UnicaenUtilisateur',
    'UnicaenUtilisateurLdapAdapter',
    'UnicaenLivelog',
    'UnicaenDbImport',
    'UnicaenEgracon',
    'Unicaen\Console',
    'UnicaenParametre',
    'Fichier',
    'Message',
    'Application',
];

// Charge les variables d'environnements du .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$applicationEnv = getenv('APPLICATION_ENV') ?: 'production';
if ('development' === $applicationEnv) {
    $modules[] = 'Laminas\DeveloperTools';
    $modules[] = 'UnicaenCode';
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
