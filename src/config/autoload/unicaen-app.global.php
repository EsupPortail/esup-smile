<?php
/**
 * Configuration globale du module UnicaenApp.
 *
 * Copiez ce fichier dans le répertoire "config/autoload" de l'application,
 * enlevez l'extension ".dist" et adaptez son contenu à vos besoins.
 */

use Laminas\Session\Config\SessionConfig;
use Laminas\Session\Storage\SessionArrayStorage;
use Laminas\Session\Validator\HttpUserAgent;
use Laminas\Session\Validator\RemoteAddr;

return [
    'unicaen-app' => [

        /**
         * Informations concernant cette application
         */
        'app_infos' => [
            'nom'     => "SMILE",
            'desc'    => "Système de gestion informatique pour la Mobilité Internationale en Ligne des Étudiants",
            //'version' => cf. 'version.global.php'
            //'date'    => cf. 'version.global.php'
            'contact' => ['mail' => "smile@unicaen.fr"],
            'mentionsLegales'        => "http://www.unicaen.fr/acces-direct/mentions-legales/",
            'informatiqueEtLibertes' => "http://www.unicaen.fr/acces-direct/informatique-et-libertes/",
        ],
    ],

    //
    // Session configuration.
    //
    'session_config' => [
        // Session cookie will expire in 1 hour.
        // 'cookie_lifetime' => 60*60*10,
        // Session data will be stored on server maximum for 30 days.
        // 'gc_maxlifetime'     => 60*60*24*30,
    ],
    //
    // Session manager configuration.
    //
    'session_manager' => [
        'config' => [
            'class' => SessionConfig::class,
            'options' => [
                'name' => 'smile',
            ],
        ],
        'storage' => SessionArrayStorage::class,
        // Session validators (used for security).
        'validators' => [
            RemoteAddr::class,
            HttpUserAgent::class,
        ]
    ],
    //
    // Session storage configuration.
    //
    'session_storage' => [
        'type' => SessionArrayStorage::class
    ],
];
