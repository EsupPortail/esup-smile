<?php

namespace Fichier\Controller;

use Fichier\Form\Upload\UploadForm;
use Fichier\Service\Fichier\FichierService;
use Fichier\Service\Nature\NatureService;
use Fichier\Service\S3\S3Service;
use Interop\Container\ContainerInterface;

class FichierControllerFactory {

    public function __invoke(ContainerInterface $container)
    {
        /**
         * @var NatureService $natureService
         * @var FichierService $fichierService
         */
        $natureService = $container->get(NatureService::class);
        $fichierService = $container->get(FichierService::class);
        $s3Service = $container->get(S3Service::class);

        /**
         * @var UploadForm $uploadForm
         */
        $uploadForm = $container->get('FormElementManager')->get(UploadForm::class);

        $controller = new FichierController();
        $controller->setNatureService($natureService);
        $controller->setFichierService($fichierService);
        $controller->setS3Service($s3Service);
        $controller->setUploadForm($uploadForm);
        return $controller;
    }
}