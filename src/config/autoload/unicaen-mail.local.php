<?php
/**
 * Configuration locale du module UnicaenMail.
 */

use UnicaenMail\Entity\Db\Mail;

$transportOptions = [
    'host' => $_ENV['MAIL_SMTP_HOST'],
    'port' => $_ENV['MAIL_SMTP_PORT'],
];

if ($_ENV['MAIL_SMTP_CONNECTION_CLASS']) {
    $transportOptions['connection_class'] = $_ENV['MAIL_SMTP_CONNECTION_CLASS'];
}
if ($_ENV['MAIL_SMTP_USERNAME']) {
    $transportOptions['connection_config']['username'] = $_ENV['MAIL_SMTP_USERNAME'];
}
if ($_ENV['MAIL_SMTP_PASSWORD']) {
    $transportOptions['connection_config']['password'] = $_ENV['MAIL_SMTP_PASSWORD'];
}
if ($_ENV['MAIL_SMTP_SSL']) {
    $transportOptions['connection_config']['ssl'] = $_ENV['MAIL_SMTP_SSL'];
}
//print_r($transportOptions);
//die();
return [
    'unicaen-mail' => [

        /**
         * Classe de entité
         **/
        'mail_entity_class' => Mail::class,

        /**
         * Options concernant l'envoi de mail par l'application
         */
        'transport_options' => $transportOptions,
        'module' => [
            'default' => [
                'redirect_to' => [$_ENV['MAIL_REDIRECT_TO']],
                'do_not_send' => $_ENV['MAIL_DO_NOT_SEND'] == "true",
                'redirect' => $_ENV['MAIL_REDIRECT'] == "true",
                /**
                 * Configuration de l'expéditeur
                 */
                'subject_prefix' => 'SMILE-Local',
                'from_name' => 'Smile',
                'from_email' => $_ENV['MAIL_FROM'] ?? 'ne-pas-repondre@unicaen.fr'
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