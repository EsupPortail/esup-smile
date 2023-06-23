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
        /**
         * Adresses des redirection si do_not_send est à true
         */
        'redirect_to' => [$_ENV['UCN_LIVELOG_REDIRECT_TO']],
        'do_not_send' => true,

        /**
         * Configuration de l'expéditeur
         */
        'subject_prefix' => 'SMILE-Local',
        'from_name' => 'Smile',
        'from_email' => 'ne-pas-repondre@unicaen.fr'
    ],
];