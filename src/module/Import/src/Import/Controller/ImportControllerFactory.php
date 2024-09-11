<?php

namespace Import\Controller;

use Import\Form\Upload\UploadForm;
use Import\Service\Import\ImportService;
use Import\Service\Nature\NatureService;
use Interop\Container\ContainerInterface;

class ImportControllerFactory {

    public function __invoke(ContainerInterface $container)
    {
        $importService = $container->get(ImportService::class);

        /** @var ImportController $controller */
        $controller = new ImportController();
        $controller->setImportService($importService);
        return $controller;
    }
}