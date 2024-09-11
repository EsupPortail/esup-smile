<?php

namespace Application\Application\Service\Step;

use Application\Service\Step\StepService;

/**
 * Trait ComposanteServiceAwareTrait
 * @package Application\Application\Service\Composante
 */
Trait StepServiceAwareTrait
{
    /** @var StepService */
    protected StepService $stepService;

    /**
     * @return StepService
     */
    public function getStepService(): StepService
    {
        return $this->stepService;
    }

    /**
     * @param StepService $stepService
     */
    public function setStepService(StepService $stepService): void
    {
        $this->stepService = $stepService;
    }
}