<?php

return [
    'translator' => [
//        'locale' => 'fr_FR',
        'supported_locales' => ['fr_FR', 'en_GB'],
        'translation_file_patterns' => [
            [
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ],
        ],
        'adapter' => 'Laminas\I18n\Translator\Loader\Gettext',
        'strategy' => 'Laminas\I18n\Translator\Strategy\Session',
    ],
];
