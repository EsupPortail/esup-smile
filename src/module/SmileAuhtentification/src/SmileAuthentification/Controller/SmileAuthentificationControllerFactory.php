<?php

namespace SmileAuthentification\Controller;

use Application\Service\Inscription\InscriptionService;
use SmileAuthentification\Service\SmileAuthentification\SmileAuthentificationService;
use Interop\Container\ContainerInterface;
use UnicaenMail\Service\Mail\MailService;
use UnicaenUtilisateur\Service\User\UserService;

class SmileAuthentificationControllerFactory {

    public function __invoke(ContainerInterface $container)
    {
        /**
         * @var SmileAuthentificationService $sauthService
         */
        $sauthService = $container->get(SmileAuthentificationService::class);

        /** @var SmileAuthentificationController $controller */
        $controller = new SmileAuthentificationController();
        $controller->setSmileAuthentificationService($sauthService);


        return $controller;
    }
}