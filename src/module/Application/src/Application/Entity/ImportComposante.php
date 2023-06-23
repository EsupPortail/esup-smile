<?php

namespace Application\Entity;

/**
 * ImportComposante
 */
class ImportComposante
{
    /**
     * @var int
     */
    private $sourceId;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string|null
     */
    private $acronyme;

    /**
     * @var string|null
     */
    private $libelle;

    /**
     * @var string|null
     */
    private $libelleLong;

    /**
     * @var \DateTime
     */
    private $histoCreation = 'now()';

    /**
     * @var int
     */
    private $histoCreateurId;

    /**
     * @var \DateTime|null
     */
    private $histoModification;

    /**
     * @var int|null
     */
    private $histoModificateurId;

    /**
     * @var \DateTime|null
     */
    private $histoDestruction;

    /**
     * @var int|null
     */
    private $histoDestructeurId;

    /**
     * @var int
     */
    private $id;


    /**
     * Set sourceId.
     *
     * @param int $sourceId
     *
     * @return ImportComposante
     */
    public function setSourceId($sourceId)
    {
        $this->sourceId = $sourceId;

        return $this;
    }

    /**
     * Get sourceId.
     *
     * @return int
     */
    public function getSourceId()
    {
        return $this->sourceId;
    }

    /**
     * Set code.
     *
     * @param string $code
     *
     * @return ImportComposante
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
     * Set acronyme.
     *
     * @param string|null $acronyme
     *
     * @return ImportComposante
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
     * Set libelle.
     *
     * @param string|null $libelle
     *
     * @return ImportComposante
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
     * Set libelleLong.
     *
     * @param string|null $libelleLong
     *
     * @return ImportComposante
     */
    public function setLibelleLong($libelleLong = null)
    {
        $this->libelleLong = $libelleLong;

        return $this;
    }

    /**
     * Get libelleLong.
     *
     * @return string|null
     */
    public function getLibelleLong()
    {
        return $this->libelleLong;
    }

    /**
     * Set histoCreation.
     *
     * @param \DateTime $histoCreation
     *
     * @return ImportComposante
     */
    public function setHistoCreation($histoCreation)
    {
        $this->histoCreation = $histoCreation;

        return $this;
    }

    /**
     * Get histoCreation.
     *
     * @return \DateTime
     */
    public function getHistoCreation()
    {
        return $this->histoCreation;
    }

    /**
     * Set histoCreateurId.
     *
     * @param int $histoCreateurId
     *
     * @return ImportComposante
     */
    public function setHistoCreateurId($histoCreateurId)
    {
        $this->histoCreateurId = $histoCreateurId;

        return $this;
    }

    /**
     * Get histoCreateurId.
     *
     * @return int
     */
    public function getHistoCreateurId()
    {
        return $this->histoCreateurId;
    }

    /**
     * Set histoModification.
     *
     * @param \DateTime|null $histoModification
     *
     * @return ImportComposante
     */
    public function setHistoModification($histoModification = null)
    {
        $this->histoModification = $histoModification;

        return $this;
    }

    /**
     * Get histoModification.
     *
     * @return \DateTime|null
     */
    public function getHistoModification()
    {
        return $this->histoModification;
    }

    /**
     * Set histoModificateurId.
     *
     * @param int|null $histoModificateurId
     *
     * @return ImportComposante
     */
    public function setHistoModificateurId($histoModificateurId = null)
    {
        $this->histoModificateurId = $histoModificateurId;

        return $this;
    }

    /**
     * Get histoModificateurId.
     *
     * @return int|null
     */
    public function getHistoModificateurId()
    {
        return $this->histoModificateurId;
    }

    /**
     * Set histoDestruction.
     *
     * @param \DateTime|null $histoDestruction
     *
     * @return ImportComposante
     */
    public function setHistoDestruction($histoDestruction = null)
    {
        $this->histoDestruction = $histoDestruction;

        return $this;
    }

    /**
     * Get histoDestruction.
     *
     * @return \DateTime|null
     */
    public function getHistoDestruction()
    {
        return $this->histoDestruction;
    }

    /**
     * Set histoDestructeurId.
     *
     * @param int|null $histoDestructeurId
     *
     * @return ImportComposante
     */
    public function setHistoDestructeurId($histoDestructeurId = null)
    {
        $this->histoDestructeurId = $histoDestructeurId;

        return $this;
    }

    /**
     * Get histoDestructeurId.
     *
     * @return int|null
     */
    public function getHistoDestructeurId()
    {
        return $this->histoDestructeurId;
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
