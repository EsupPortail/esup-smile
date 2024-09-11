<?php

return [
    'unicaen-fichier' => [
        'upload-path' => 'public/upload/',

        // true if you use Amazon S3, all the credentials/configuration are in env variables
        's3' => true
    ],
    'service_manager' => [
        'factories' => [
            \Symfony\Component\Console\Application::class => \Application\Console\ConsoleApplicationFactory::class,
        ],
    ],
];