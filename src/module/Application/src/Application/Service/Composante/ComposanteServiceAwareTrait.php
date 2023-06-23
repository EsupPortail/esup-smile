<?php

namespace Application\Application\Service\Composante;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Trait ComposanteServiceAwareTrait
 * @package Application\Application\Service\Composante
 */
Trait ComposanteServiceAwareTrait
{
    /** @var ComposanteService */
    protected $composanteService;

    /**
     * @return ComposanteService
     */
    public function getComposanteService(): ComposanteService
    {
        return $this->composanteService;
    }

    /**
     * @param ComposanteService $composanteService
     */
    public function setComposanteService(ComposanteService $composanteService): void
    {
        $this->composanteService = $composanteService;
    }

}