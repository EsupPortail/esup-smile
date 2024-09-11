<?php

namespace Import\Service\MySynchro;

trait MySynchroServiceAwareTrait
{

    private MySynchroService $synchronisationService;

    public function getMySynchroService(): MySynchroService
    {
        return $this->synchronisationService;
    }

    public function setMySynchroService(MySynchroService $synchronisationService): void
    {
        $this->synchronisationService = $synchronisationService;
    }

}