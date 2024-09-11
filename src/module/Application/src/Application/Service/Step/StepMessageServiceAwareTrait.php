<?php

namespace Application\Application\Service\Step;


use Application\Service\Step\StepMessageService;

/**
 * Trait ComposanteServiceAwareTrait
 *
 * @package Application\Application\Service\Composante
 */
Trait StepMessageServiceAwareTrait
{
    /** @var StepMessageService */
    protected StepMessageService $stepMessageService;

    /**
     * @return StepMessageService
     */
    public function getStepMessageService(): StepMessageService
    {
        return $this->stepMessageService;
    }

    /**
     * @param StepMessageService $stepMessageService
     */
    public function setStepMessageService(StepMessageService $stepMessageService): void
    {
        $this->stepMessageService = $stepMessageService;
    }
}