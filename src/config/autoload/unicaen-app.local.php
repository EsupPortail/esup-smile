<?php
/**
 * Configuration locale du module UnicaenApp.
 *
 * If you have a ./config/autoload/ directory set up for your project,
 * drop this config file in it and change the values as you wish.
 */
return [
    'unicaen-app' => [
        /**
         * Paramétrage pour utilisation pour autorisation ou non à la connexion à
         * une app de l'exterieur de l'établissement
         */
        'hostlocalization' => [
            'activated' => false,

            'proxies' => [
                //xxx.xx.xx.xxx
            ],

            'reverse-proxies' => [
                //xxx.xx.xx.xxx
            ],

            'masque-ip' => '',

        ],
        /**
         * Mode maintenance (application indisponible)
         */
        'maintenance' => [
            // activation (TRUE: activé, FALSE: désactivé)
            'enable' => false,
            // message à afficher
            'message' => "L'application est temporairement indisponible pour des raisons de maintenance, veuillez nous excuser pour la gêne occasionnée.",
            // le mode console est-il aussi concerné (TRUE: oui, FALSE: non)
            'include_cli' => false,
            // liste blanche des adresses IP clientes à laisser passer
            'white_list' => [
                // Formats possibles : [ REMOTE_ADDR ] ou [ REMOTE_ADDR, HTTP_X_FORWARDED_FOR ]
                // exemples :
                // ['127.0.0.1'], // localhost
                // ['172.17.0.1'], // Docker container
                // ['195.220.135.97', '194.199.107.33'], // Via proxy
            ],
        ],
    ],
];