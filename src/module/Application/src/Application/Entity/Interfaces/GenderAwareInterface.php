<?php

namespace  Application\Application\Entity\Interfaces;

interface GenderAwareInterface
{
    const MASCULIN = 1;
    const FEMININ = 2;
    const NEUTRE = 3;

    /**
     * permet dans certains cas à gérer les accords de genre dans certains cas
     * @return int
     */
    public function getEntityGenre(): int;

}