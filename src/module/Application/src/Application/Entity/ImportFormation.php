<?php

namespace Application\Entity;

/**
 * ImportFormation
 */
class ImportFormation
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
    private $libelle;

    /**
     * @var string|null
     */
    private $acronyme;

    /**
     * @var int
     */
    private $niveauEtude = '0';

    /**
     * @var string|null
     */
    private $typeDiplomeCode;

    /**
     * @var string|null
     */
    private $typeFormationCode;

    /**
     * @var string|null
     */
    private $composanteCode;

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
     * @return ImportFormation
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
     * @return ImportFormation
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
     * @return ImportFormation
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
     * @return ImportFormation
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
     * Set niveauEtude.
     *
     * @param int $niveauEtude
     *
     * @return ImportFormation
     */
    public function setNiveauEtude($niveauEtude)
    {
        $this->niveauEtude = $niveauEtude;

        return $this;
    }

    /**
     * Get niveauEtude.
     *
     * @return int
     */
    public function getNiveauEtude()
    {
        return $this->niveauEtude;
    }

    /**
     * Set typeDiplomeCode.
     *
     * @param string|null $typeDiplomeCode
     *
     * @return ImportFormation
     */
    public function setTypeDiplomeCode($typeDiplomeCode = null)
    {
        $this->typeDiplomeCode = $typeDiplomeCode;

        return $this;
    }

    /**
     * Get typeDiplomeCode.
     *
     * @return string|null
     */
    public function getTypeDiplomeCode()
    {
        return $this->typeDiplomeCode;
    }

    /**
     * Set typeFormationCode.
     *
     * @param string|null $typeFormationCode
     *
     * @return ImportFormation
     */
    public function setTypeFormationCode($typeFormationCode = null)
    {
        $this->typeFormationCode = $typeFormationCode;

        return $this;
    }

    /**
     * Get typeFormationCode.
     *
     * @return string|null
     */
    public function getTypeFormationCode()
    {
        return $this->typeFormationCode;
    }

    /**
     * Set composanteCode.
     *
     * @param string|null $composanteCode
     *
     * @return ImportFormation
     */
    public function setComposanteCode($composanteCode = null)
    {
        $this->composanteCode = $composanteCode;

        return $this;
    }

    /**
     * Get composanteCode.
     *
     * @return string|null
     */
    public function getComposanteCode()
    {
        return $this->composanteCode;
    }

    /**
     * Set histoCreation.
     *
     * @param \DateTime $histoCreation
     *
     * @return ImportFormation
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
     * @return ImportFormation
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
     * @return ImportFormation
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
     * @return ImportFormation
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
     * @return ImportFormation
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
     * @return ImportFormation
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
