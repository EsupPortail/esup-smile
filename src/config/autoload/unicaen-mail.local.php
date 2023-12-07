<?php
/**
 * Configuration locale du module UnicaenMail.
 */

use UnicaenMail\Entity\Db\Mail;

return [
    'unicaen-mail' => [

        /**
         * Classe de entité
         **/
        'mail_entity_class' => Mail::class,

        /**
         * Options concernant l'envoi de mail par l'application
         */
        'transport_options' => [
            'host' => $_ENV['UCN_LIVELOG_HOST'],
            'port' => $_ENV['UCN_LIVELOG_PORT'],
        ],
        'module' => [
            'default' => [
                'redirect_to' => [$_ENV['UCN_LIVELOG_REDIRECT_TO']],
                'do_not_send' => [$_ENV['UCN_LIVELOG_DO_NOT_SEND']],
                /**
                 * Configuration de l'expéditeur
                 */
                'subject_prefix' => 'SMILE-Local',
                'from_name' => 'Smile',
                'from_email' => 'ne-pas-repondre@unicaen.fr'
            ],
            /** On peut ajouter un clef de module pour la référencer dans la méthode sendMail afin d'exploiter les données passée en valeur. */
            //            'MonPetitModule' => [
            //                'redirect_to' =>  ['XXX@XXX.XX',],
            //                'do_not_send' => true,
            //                'subject_prefix' => 'Mes petit module',
            //                'from_name' => 'mon-ptit-module',
            //                'from_email' => 'assistance.mon-petit-module@XXX.XX',
            //            ]
        ],


//        'server_url' => 'https://xxx.xxx',
    //    'service_manager' => [
    //        'delegators' => [
    //            TreeRouteStack::class => [
    //                TreeRouteStackConsoleDelegatorFactory::class,
    //            ],
    //        ]
    //    ],

        /**
         * Adresses des redirection si do_not_send est à true
         */
//        'redirect_to' => [$_ENV['UCN_LIVELOG_REDIRECT_TO']],
//        'do_not_send' => true,

        /**
         * Configuration de l'expéditeur
         */
//        'subject_prefix' => 'SMILE-Local',
//        'from_name' => 'Smile',
//        'from_email' => 'ne-pas-repondre@unicaen.fr'
    ],
];