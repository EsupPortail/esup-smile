<?php

namespace Application\Entity;

/**
 * Mobilite
 */
class Mobilite
{
    /**
     * @var string
     */
    private $libelle;

    /**
     * @var int
     */
    private $id;


    /**
     * Set libelle.
     *
     * @param string $libelle
     *
     * @return Mobilite
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle.
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
