<?php

namespace  Application\Application\Entity\Traits\Entities;

use Application\Application\Misc\RouterToolsTrait;
use Application\Application\Service\Formation\TypeDiplomeServiceAwareTrait;
use Application\Application\Service\Formation\TypeFormationServiceAwareTrait;
use Application\Entity\TypeDiplome;

trait TypeDiplomeAwareTrait
{
    /** @var TypeDiplome $typeDiplome */
    protected $typeDiplome;

    /**
     * @return TypeDiplome|null
     */
    public function getTypeDiplome(): ?TypeDiplome
    {
        return $this->typeDiplome;
    }

    /**
     * @param TypeDiplome|null $typeDiplome
     */
    public function setTypeDiplome(?TypeDiplome $typeDiplome): void
    {
        $this->typeDiplome = $typeDiplome;
    }

    /**
     * @return Bool
     */
    public function hasTypeDiplome(): Bool
    {
        return isset($this->typeDiplome);
    }

    use RouterToolsTrait;
    use TypeDiplomeServiceAwareTrait;

    /** @return TypeDiplome|null */
    protected function getTypeDiplomeFromRoute(): ?TypeDiplome
    {
        $id = $this->getParamFromRoute('typeDiplome',0);
        /** @var TypeDiplome $typeFormation */
        $typeFormation = $this->getTypeDiplomeService()->find($id);
        return $typeFormation;
    }

}