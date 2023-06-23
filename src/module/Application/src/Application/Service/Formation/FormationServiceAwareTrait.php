<?php

namespace Application\Application\Service\Formation;
/**
 * Trait FormationServiceAwareTrait
 * @package Application\Application\Service\Composante
 */
trait FormationServiceAwareTrait
{
    /** @var FormationService $formationService */
    protected $formationService;

    /**
     * @return FormationService
     */
    public function getFormationService(): FormationService
    {
        return $this->formationService;
    }

    /**
     * @param FormationService $formationService
     */
    public function setFormationService(FormationService $formationService): void
    {
        $this->formationService = $formationService;
    }

}