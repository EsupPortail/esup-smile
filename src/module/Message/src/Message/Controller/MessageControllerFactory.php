<?php

namespace Message\Controller;

use Application\Service\Inscription\InscriptionService;
use Message\Service\Message\MessageService;
use Interop\Container\ContainerInterface;
use UnicaenMail\Service\Mail\MailService;
use UnicaenUtilisateur\Service\User\UserService;

class MessageControllerFactory {

    public function __invoke(ContainerInterface $container)
    {
        /**
         * @var MessageService $messageService
         */
        $messageService = $container->get(MessageService::class);

        /** @var MessageController $controller */
        $controller = new MessageController();
        $controller->setMessageService($messageService);

        $userService = $container->get(UserService::class);
        $controller->setUserService($userService);

        $inscription = $container->get(InscriptionService::class);
        $controller->setInscriptionService($inscription);

        $mailService = $container->get(MailService::class);
        $controller->setMailService($mailService);

        return $controller;
    }
}