<?php

namespace Application\Application\Service\Formation;
/**
 * Trait TypeFormationServiceAwareTrait
 * @package Application\Application\Service\Composante
 */
trait TypeFormationServiceAwareTrait
{
    /** @var TypeFormationService $typeFormationService */
    protected $typeFormationService;

    /**
     * @return TypeFormationService
     */
    public function getTypeFormationService(): TypeFormationService
    {
        return $this->typeFormationService;
    }

    /**
     * @param TypeFormationService $typeFormationService
     */
    public function setTypeFormationService(TypeFormationService $typeFormationService): void
    {
        $this->typeFormationService = $typeFormationService;
    }

}