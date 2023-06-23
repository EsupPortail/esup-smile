<?php


namespace Application\Application\Service\API;


use Adapter\Entity\Interfaces\EntityAdapterInterface;
use Adapter\Entity\Interfaces\FormationAdapterInterface;
use Application\Application\Entity\Interfaces\SourceAwareInterface;

interface SourceAwareEntityServiceInterface extends EntityServiceInterface
{
    /**
     * @param  string code
     * @return SourceAwareInterface[]
     */
    public function findByCode(string $code) : array;
}