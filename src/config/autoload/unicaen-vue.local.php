<?php

return [
    /* Configuration d'UnicaenVue */
    // utile uniquement en mode DEV, pas en test ni en prod où Node ne sera pas utilisé
    'unicaen-vue' => [
        // URL d'accès au serveur Node pour le hot-loading (inutile en prod ou en test)
        'host'        => 'http://localhost:5133',

        // Activation du hot-loading ou non TRUE en mode développement, FALSE pour du test ou de la prod
        'hot-loading' => true,
    ],
];