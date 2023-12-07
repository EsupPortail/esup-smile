<?php

namespace Import\Service\Import;

trait ImportServiceAwareTrait {

    /** @var ImportService $importService */
    private $importService;

    /**
     * @return ImportService
     */
    public function getImportService()
    {
        return $this->importService;
    }

    /**
     * @param ImportService $importService
     * @return ImportService
     */
    public function setImportService($importService)
    {
        $this->importService = $importService;
        return $this->importService;
    }


}