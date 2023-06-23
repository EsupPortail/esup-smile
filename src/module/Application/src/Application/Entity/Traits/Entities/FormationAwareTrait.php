<?php

namespace  Application\Application\Entity\Traits\Entities;

use Application\Application\Misc\RouterToolsTrait;
use Application\Application\Service\Formation\FormationServiceAwareTrait;
use Application\Entity\Formation;

trait FormationAwareTrait
{
    /** @var Formation $Formation */
    protected $formation;

    /**
     * @return Formation|null
     */
    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    /**
     * @param Formation|null $formation
     */
    public function setFormation(?Formation $formation): void
    {
        $this->formation = $formation;
    }

    /**
     * @return Bool
     */
    public function hasFormation(): Bool
    {
        return isset($this->formation);
    }

    use RouterToolsTrait;
    use FormationServiceAwareTrait;

    /** @return Formation|null */
    protected function getFormationFromRoute(): ?Formation
    {
        $id = $this->getParamFromRoute('formation',0);
        /** @var Formation $formation */
        $formation = $this->getFormationService()->find($id);
        return $formation;
    }

}