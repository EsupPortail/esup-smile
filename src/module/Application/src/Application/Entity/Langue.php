<?php

namespace Application\Entity;

/**
 * Langue
 */
class Langue
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $libelle;

    /**
     * @var string
     */
    private $libelleEn;

    /**
     * @var int
     */
    private $id;


    /**
     * Set code.
     *
     * @param string $code
     *
     * @return Langue
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set libelle.
     *
     * @param string $libelle
     *
     * @return Langue
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
     * Set libelleEn.
     *
     * @param string $libelleEn
     *
     * @return Langue
     */
    public function setLibelleEn($libelleEn)
    {
        $this->libelleEn = $libelleEn;

        return $this;
    }

    /**
     * Get libelleEn.
     *
     * @return string
     */
    public function getLibelleEn()
    {
        return $this->libelleEn;
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
