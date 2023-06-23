<?php

namespace Application\Entity;

/**
 * Etablissement
 */
class Etablissement
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
     * @var int
     */
    private $id;

    /**
     * @var \Application\Entity\Pays
     */
    private $pays;


    /**
     * Set code.
     *
     * @param string $code
     *
     * @return Etablissement
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
     * @return Etablissement
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

    /**
     * Set pays.
     *
     * @param \Application\Entity\Pays|null $pays
     *
     * @return Etablissement
     */
    public function setPays(\Application\Entity\Pays $pays = null)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays.
     *
     * @return \Application\Entity\Pays|null
     */
    public function getPays()
    {
        return $this->pays;
    }
}
