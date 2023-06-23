<?php

namespace Application\Application\Service\Formation;
/**
 * Trait TypeFormationServiceAwareTrait
 * @package Application\Application\Service\Composante
 */
trait TypeDiplomeServiceAwareTrait
{
    /** @var TypeDiplomeService $typeDiplomeService */
    protected $typeDiplomeService;

    /**
     * @return TypeDiplomeService
     */
    public function getTypeDiplomeService(): TypeDiplomeService
    {
        return $this->typeDiplomeService;
    }

    /**
     * @param TypeDiplomeService $typeDiplomeService
     */
    public function setTypeDiplomeService(TypeDiplomeService $typeDiplomeService): void
    {
        $this->typeDiplomeService = $typeDiplomeService;
    }

}