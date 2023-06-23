<?php

namespace Application\Entity;

/**
 * TypeDiplome
 */
class TypeDiplome
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string|null
     */
    private $libelle;

    /**
     * @var string|null
     */
    private $acronyme;

    /**
     * @var int
     */
    private $ordre = '1';

    /**
     * @var int
     */
    private $id;


    /**
     * Set code.
     *
     * @param string $code
     *
     * @return TypeDiplome
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
     * @param string|null $libelle
     *
     * @return TypeDiplome
     */
    public function setLibelle($libelle = null)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle.
     *
     * @return string|null
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set acronyme.
     *
     * @param string|null $acronyme
     *
     * @return TypeDiplome
     */
    public function setAcronyme($acronyme = null)
    {
        $this->acronyme = $acronyme;

        return $this;
    }

    /**
     * Get acronyme.
     *
     * @return string|null
     */
    public function getAcronyme()
    {
        return $this->acronyme;
    }

    /**
     * Set ordre.
     *
     * @param int $ordre
     *
     * @return TypeDiplome
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre.
     *
     * @return int
     */
    public function getOrdre()
    {
        return $this->ordre;
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
