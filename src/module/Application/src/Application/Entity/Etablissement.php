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
     * @var string|null
     */
    private $pic;

    /**
     * @var string|null
     */
    private $oid;

    /**
     * @var string
     */
    private $libelle;

    /**
     * @var string|null
     */
    private $postCode;

    /**
     * @var string|null
     */
    private $street;

    /**
     * @var string|null
     */
    private $city;

    /**
     * @var string|null
     */
    private $paysCode;

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
     * Set pic.
     *
     * @param string|null $pic
     *
     * @return Etablissement
     */
    public function setPic($pic = null)
    {
        $this->pic = $pic;

        return $this;
    }

    /**
     * Get pic.
     *
     * @return string|null
     */
    public function getPic()
    {
        return $this->pic;
    }

    /**
     * Set oid.
     *
     * @param string|null $oid
     *
     * @return Etablissement
     */
    public function setOid($oid = null)
    {
        $this->oid = $oid;

        return $this;
    }

    /**
     * Get oid.
     *
     * @return string|null
     */
    public function getOid()
    {
        return $this->oid;
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
     * Set postCode.
     *
     * @param string|null $postCode
     *
     * @return Etablissement
     */
    public function setPostCode($postCode = null)
    {
        $this->postCode = $postCode;

        return $this;
    }

    /**
     * Get postCode.
     *
     * @return string|null
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * Set street.
     *
     * @param string|null $street
     *
     * @return Etablissement
     */
    public function setStreet($street = null)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street.
     *
     * @return string|null
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set city.
     *
     * @param string|null $city
     *
     * @return Etablissement
     */
    public function setCity($city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city.
     *
     * @return string|null
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set paysCode.
     *
     * @param string|null $paysCode
     *
     * @return Etablissement
     */
    public function setPaysCode($paysCode = null)
    {
        $this->paysCode = $paysCode;

        return $this;
    }

    /**
     * Get paysCode.
     *
     * @return string|null
     */
    public function getPaysCode()
    {
        return $this->paysCode;
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
