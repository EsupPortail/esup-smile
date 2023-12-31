<?php

namespace Fichier\Entity\Db;


use Application\Provider\Validation\JustificatifValidations;
use UnicaenUtilisateur\Entity\Db\HistoriqueAwareInterface;
use UnicaenUtilisateur\Entity\Db\HistoriqueAwareTrait;
use UnicaenValidation\Entity\HasValidationsInterface;
use UnicaenValidation\Entity\HasValidationsTrait;

//class Fichier implements HistoriqueAwareInterface, HasValidationsInterface {
class Fichier implements HistoriqueAwareInterface{
    use HistoriqueAwareTrait;
//    use HasValidationsTrait;

    /** @var string */
    private $id;
    /** @var string */
    private $nomOriginal;
    /** @var string */
    private $nomStockage;
    /** @var Nature */
    private $nature;
    /** @var string */
    private $typeMime;
    /** @var string */
    private $taille;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Fichier
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getNomOriginal()
    {
        return $this->nomOriginal;
    }

    /**
     * @param string $nomOriginal
     * @return Fichier
     */
    public function setNomOriginal($nomOriginal)
    {
        $this->nomOriginal = $nomOriginal;
        return $this;
    }

    /**
     * @return string
     */
    public function getNomStockage()
    {
        return $this->nomStockage;
    }

    /**
     * @param string $nomStockage
     * @return Fichier
     */
    public function setNomStockage($nomStockage)
    {
        $this->nomStockage = $nomStockage;
        return $this;
    }

    /**
     * @return Nature
     */
    public function getNature()
    {
        return $this->nature;
    }

    /**
     * @param Nature $nature
     * @return Fichier
     */
    public function setNature($nature)
    {
        $this->nature = $nature;
        return $this;
    }

    /**
     * @return string
     */
    public function getTypeMime()
    {
        return $this->typeMime;
    }

    /**
     * @param string $typeMime
     * @return Fichier
     */
    public function setTypeMime($typeMime)
    {
        $this->typeMime = $typeMime;
        return $this;
    }

    /**
     * @return string
     */
    public function getTaille()
    {
        return $this->taille;
    }

    /**
     * @param string $taille
     * @return Fichier
     */
    public function setTaille($taille)
    {
        $this->taille = $taille;
        return $this;
    }

    public function estRefuse() : bool
    {
        $validation = $this->getValidationActiveByTypeCode(JustificatifValidations::JUSTIFICATIF_VALIDATION);
        if ($validation !== null AND $validation->getValeur() === 'non') return false;
        return true;
    }
}