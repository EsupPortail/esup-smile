<?php

namespace SmileAuthentification\Service\SmileAuthentification;

trait SmileAuthentificationServiceAwareTrait {

    private SmileAuthentificationService $smileAuthentification;

    public function getSmileAuthentificationService(): SmileAuthentificationService
    {
        return $this->smileAuthentificationService;
    }

    /**
     * @param SmileAuthentificationService $smileAuthentification
     *
     * @return SmileAuthentificationService
     */
    public function setSmileAuthentificationService(SmileAuthentificationService $smileAuthentification): SmileAuthentificationService
    {
        $this->smileAuthentificationService = $smileAuthentification;
        return $this->smileAuthentificationService;
    }


}