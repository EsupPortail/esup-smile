<?php

namespace Application\Entity;

/**
 * Step
 */
class Step
{
    /**
     * @var string
     */
    private $libelle;

    /**
     * @var string
     */
    private $code;

    /**
     * @var int
     */
    private $id;


    /**
     * Set libelle.
     *
     * @param string $libelle
     *
     * @return Step
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
     * Set code.
     *
     * @param string $code
     *
     * @return Step
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
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
