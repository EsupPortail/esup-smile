<?php

namespace  Application\Application\Entity\Traits\Entities;

use Application\Application\Misc\RouterToolsTrait;
use Application\Application\Service\Formation\TypeFormationServiceAwareTrait;
use Application\Entity\DomaineFormation;

trait DomaineFormationAwareTrait
{
    /** @var DomaineFormation $domaineFormation */
    protected $domaineFormation;

    /**
     * @return DomaineFormation|null
     */
    public function getTypeFormation(): ?DomaineFormation
    {
        return $this->typeFormation;
    }

    /**
     * @param DomaineFormation|null $domaineFormation
     */
    public function setTypeFormation(?DomaineFormation $domaineFormation): void
    {
        $this->typeFormation = $domaineFormation;
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

    /** @return DomaineFormation|null */
    protected function getTypeFormationFromRoute(): ?DomaineFormation
    {
        $id = $this->getParamFromRoute('typeFormation',0);
        /** @var DomaineFormation $domaineFormation */
        $domaineFormation = $this->getDomaineFormationService()->find($id);
        return $domaineFormation;
    }

}