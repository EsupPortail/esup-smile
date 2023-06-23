<?php

namespace  Application\Application\Entity\Traits\InterfacesImplementation;


use Application\Application\Entity\Interfaces\OrderAwareInterface;

trait OrderAwareTrait
{
    /** @var int $ordre */
    protected $ordre = 1;

    /**
     * @return int
     */
    public function getOrdre(): int
    {
        return $this->ordre;
    }

    /**
     * @param int $ordre
     */
    public function setOrdre(int $ordre): void
    {
        $this->ordre = $ordre;
    }

    /**
     * @param OrderAwareInterface[] $entities
     */
    public function sort(array $entities): array
    {
        usort($entities, function (OrderAwareInterface $e1, OrderAwareInterface $e2){
            return $e1->getOrdre()-$e2->getOrdre();
        });
        return $entities;
    }

}