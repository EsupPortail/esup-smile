<?php

namespace  Application\Application\Entity\Traits\Entities;

use Application\Application\Misc\RouterToolsTrait;
use Application\Application\Service\Composante\ComposanteServiceAwareTrait;
use Application\Entity\Composante;

trait ComposanteAwareTrait
{
    /** @var Composante $composante */
    protected $composante;

    /**
     * @return Composante|null
     */
    public function getComposante(): ?Composante
    {
        return $this->composante;
    }

    /**
     * @param Composante|null $composante
     */
    public function setComposante(?Composante $composante): void
    {
        $this->composante = $composante;
    }

    /**
     * @return Bool
     */
    public function hasComposante(): Bool
    {
        return isset($this->composante);
    }

    use RouterToolsTrait;
    use ComposanteServiceAwareTrait;

    /** @return Composante|null */
    protected function getComposanteFromRoute(): ?Composante
    {
        $id = $this->getParamFromRoute('composante',0);
        /** @var Composante $composante */
        $composante = $this->getComposanteService()->find($id);
        return $composante;
    }

}