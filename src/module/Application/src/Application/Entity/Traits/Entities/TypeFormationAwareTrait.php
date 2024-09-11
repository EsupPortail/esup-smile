<?php

namespace  Application\Application\Entity\Traits\Entities;

use Application\Application\Misc\RouterToolsTrait;
use Application\Application\Service\Formation\TypeFormationServiceAwareTrait;
use Application\Entity\TypeFormation;

trait TypeFormationAwareTrait
{
    /** @var TypeFormation $typeFormation */
    protected $typeFormation;

    /**
     * @return TypeFormation|null
     */
    public function getTypeFormation(): ?TypeFormation
    {
        return $this->typeFormation;
    }

    /**
     * @param TypeFormation|null $typeFormation
     */
    public function setTypeFormation(?TypeFormation $typeFormation): void
    {
        $this->typeFormation = $typeFormation;
    }

    /**
     * @return Bool
     */
    public function hasTypeFormation(): Bool
    {
        return isset($this->typeFormation);
    }

    use RouterToolsTrait;
    use TypeFormationServiceAwareTrait;

    /** @return TypeFormation|null */
    protected function getTypeFormationFromRoute(): ?TypeFormation
    {
        $id = $this->getParamFromRoute('typeFormation',0);
        /** @var TypeFormation $typeFormation */
        $typeFormation = $this->getTypeFormationService()->find($id);
        return $typeFormation;
    }

}