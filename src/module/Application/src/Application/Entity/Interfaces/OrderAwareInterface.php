<?php

namespace  Application\Application\Entity\Interfaces;
/**
 * Pour faire le liens entre les données est différentes sources externes possible
 */
interface OrderAwareInterface
{
    /**
     * @return int
     */
    public function getOrdre(): int;
    /**
     * @param int $ordre
     */
    public function setOrdre(int $ordre): void;

    /**
     * @param OrderAwareInterface[] $entities
     */
    public function sort(array $entities) : array;

}