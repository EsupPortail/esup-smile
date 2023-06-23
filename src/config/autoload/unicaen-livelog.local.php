<?php

namespace UnicaenLivelog;

return [
    'unicaen-livelog' => [
        /**
         * Configuration de la websocket.
         */
        'websocket' => [
            /**
             * Adresse "privée" à laquelle écoute la websocket.
             */
            'private_url' => '0.0.0.0:7443',

            /**
             * Adresse "public" à laquelle la websocket est accessible par les clients (navigateurs).
             * Dans cet exemple, un navigateur web pourrait se connecter à l'adresse 'wss://serveur.unicaen.fr/livelog'.
             */
            'public_url' => '/livelog',

            /**
             * Mode verbeux ou pas.
             */
            'verbose' => false,
        ],
        /**
         * Configuration de la socket.
         */
        'socket' => [
            /**
             * Chemin de la socket Unix.
             */
            'path' => 'unix:///tmp/unicaen_livelog.sock',

            /**
             * Mode verbeux ou pas.
             */
            'verbose' => false,
        ],
    ],
];