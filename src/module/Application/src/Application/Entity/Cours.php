<?php

namespace Application\Entity;

use Application\Application\Entity\Interfaces\HistoriqueAwareInterface;
use Application\Application\Entity\Interfaces\ImportInterface;
use Application\Application\Entity\Interfaces\SourceAwareInterface;
use Application\Application\Entity\Traits\InterfacesImplementation\HistoriqueAwareTrait;
use Application\Application\Entity\Traits\InterfacesImplementation\ImportAwareTrait;
use Application\Application\Entity\Traits\InterfacesImplementation\SourceAwareTrait;
use DateTime;
use Laminas\Permissions\Acl\Resource\ResourceInterface;
use UnicaenUtilisateur\Entity\Db\User;
use UnicaenUtilisateur\Entity\Db\UserInterface;

/**
 * Cours
 */
class Cours implements ResourceInterface,
                           HistoriqueAwareInterface,
                           SourceAwareInterface,
                           ImportInterface

{
    use HistoriqueAwareTrait;
    use SourceAwareTrait;
    use ImportAwareTrait;


    const RESOURCE_ID = 'Cours';

    /**
     * @var string|null
     */
    private $codeElp;

    /**
     * @var string|null
     */
    private $libelle;

    /**
     * @var string|null
     */
    private $objectif;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var string|null
     */
    private $typeCours;

    /**
     * @var string|null
     */
    private $langueEnseignement;

    /**
     * @var string|null
     */
    private $s1;

    /**
     * @var string|null
     */
    private $s2;

    /**
     * @var string|null
     */
    private $ects;

    /**
     * @var string|null
     */
    private $volElp;

    /**
     * @var bool|null
     */
    private $ouvertMobilite = true;

    /**
     * @var string
     */
    private $sourceCode;

    /**
     * @var int
     */
    private $id;

    /**
     * @var \Application\Entity\Formation
     */
    private $formation;

    /**
     * @var \Application\Entity\Langue
     */
    private $langueEnseignement2;

    /**
     * @var \UnicaenDbImport\Entity\Db\Source
     */
    protected $source;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $inscription;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $inscriptionCours;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $mobilite;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->inscription = new \Doctrine\Common\Collections\ArrayCollection();
        $this->mobilite = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codeElp.
     *
     * @param string|null $codeElp
     *
     * @return Cours
     */
    public function setCodeElp($codeElp = null)
    {
        $this->codeElp = $codeElp;

        return $this;
    }

    /**
     * Get codeElp.
     *
     * @return string|null
     */
    public function getCodeElp()
    {
        return $this->codeElp;
    }

    /**
     * Set libelle.
     *
     * @param string|null $libelle
     *
     * @return Cours
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
     * Set objectif.
     *
     * @param string|null $objectif
     *
     * @return Cours
     */
    public function setObjectif($objectif = null)
    {
        $this->objectif = $objectif;

        return $this;
    }

    /**
     * Get objectif.
     *
     * @return string|null
     */
    public function getObjectif()
    {
        return $this->objectif;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return Cours
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set typeCours.
     *
     * @param string|null $typeCours
     *
     * @return Cours
     */
    public function setTypeCours($typeCours = null)
    {
        $this->typeCours = $typeCours;

        return $this;
    }

    /**
     * Get typeCours.
     *
     * @return string|null
     */
    public function getTypeCours()
    {
        return $this->typeCours;
    }

    /**
     * Set langueEnseignement.
     *
     * @param string|null $langueEnseignement
     *
     * @return Cours
     */
    public function setLangueEnseignement($langueEnseignement = null)
    {
        $this->langueEnseignement = $langueEnseignement;

        return $this;
    }

    /**
     * Get langueEnseignement.
     *
     * @return string|null
     */
    public function getLangueEnseignement()
    {
        return $this->langueEnseignement;
    }

    /**
     * Set s1.
     *
     * @param string|null $s1
     *
     * @return Cours
     */
    public function setS1($s1 = null)
    {
        $this->s1 = $s1;

        return $this;
    }

    /**
     * Get s1.
     *
     * @return string|null
     */
    public function getS1()
    {
        return $this->s1;
    }

    /**
     * Set s2.
     *
     * @param string|null $s2
     *
     * @return Cours
     */
    public function setS2($s2 = null)
    {
        $this->s2 = $s2;

        return $this;
    }

    /**
     * Get s2.
     *
     * @return string|null
     */
    public function getS2()
    {
        return $this->s2;
    }

    /**
     * Set ects.
     *
     * @param string|null $ects
     *
     * @return Cours
     */
    public function setEcts($ects = null)
    {
        $this->ects = $ects;

        return $this;
    }

    /**
     * Get ects.
     *
     * @return string|null
     */
    public function getEcts()
    {
        return $this->ects;
    }

    /**
     * Set volElp.
     *
     * @param string|null $volElp
     *
     * @return Cours
     */
    public function setVolElp($volElp = null)
    {
        $this->volElp = $volElp;

        return $this;
    }

    /**
     * Get volElp.
     *
     * @return string|null
     */
    public function getVolElp()
    {
        return $this->volElp;
    }

    /**
     * Set ouvertMobilite.
     *
     * @param bool|null $ouvertMobilite
     *
     * @return Cours
     */
    public function setOuvertMobilite($ouvertMobilite = null)
    {
        $this->ouvertMobilite = $ouvertMobilite;

        return $this;
    }

    /**
     * Get ouvertMobilite.
     *
     * @return bool|null
     */
    public function getOuvertMobilite()
    {
        return $this->ouvertMobilite;
    }

    /**
     * Set sourceCode.
     *
     * @param string $sourceCode
     *
     * @return Cours
     */
    public function setSourceCode($sourceCode): void
    {
        $this->sourceCode = $sourceCode;
    }

    /**
     * Get sourceCode.
     *
     * @return string
     */
    public function getSourceCode(): string
    {
        return $this->sourceCode ?? '';
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set formation.
     *
     * @param \Application\Entity\Formation|null $formation
     *
     * @return Cours
     */
    public function setFormation(\Application\Entity\Formation $formation = null)
    {
        $this->formation = $formation;

        return $this;
    }

    /**
     * Get formation.
     *
     * @return \Application\Entity\Formation|null
     */
    public function getFormation()
    {
        return $this->formation;
    }

    /**
     * Set langueEnseignement2.
     *
     * @param \Application\Entity\Langue|null $langueEnseignement2
     *
     * @return Cours
     */
    public function setLangueEnseignement2(\Application\Entity\Langue $langueEnseignement2 = null)
    {
        $this->langueEnseignement2 = $langueEnseignement2;

        return $this;
    }

    /**
     * Get langueEnseignement2.
     *
     * @return \Application\Entity\Langue|null
     */
    public function getLangueEnseignement2()
    {
        return $this->langueEnseignement2;
    }

    /**
     * Set source.
     *
     * @param Source|null $source
     *
     * @return void
     */
    public function setSource(Source $source = null): void
    {
        $this->source = $source;
    }

    /**
     * Get source.
     *
     * @return ?Source
     */
    public function getSource(): ?Source
    {
        return $this->source;
    }

    /**
     * Add inscription.
     *
     * @param \Application\Entity\Inscription $inscription
     *
     * @return Cours
     */
    public function addInscription(\Application\Entity\Inscription $inscription)
    {
        $this->inscription[] = $inscription;

        return $this;
    }

    /**
     * Remove inscription.
     *
     * @param \Application\Entity\Inscription $inscription
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeInscription(\Application\Entity\Inscription $inscription)
    {
        return $this->inscription->removeElement($inscription);
    }

    /**
     * Get inscription.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInscription()
    {
        return $this->inscription;
    }

    /**
     * Add mobilite.
     *
     * @param \Application\Entity\Mobilite $mobilite
     *
     * @return Cours
     */
    public function addMobilite(\Application\Entity\Mobilite $mobilite)
    {
        $this->mobilite[] = $mobilite;

        return $this;
    }

    /**
     * Remove mobilite.
     *
     * @param \Application\Entity\Mobilite $mobilite
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeMobilite(\Application\Entity\Mobilite $mobilite)
    {
        return $this->mobilite->removeElement($mobilite);
    }

    /**
     * Get mobilite.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMobilite()
    {
        return $this->mobilite;
    }

    /**
     * Is mobilite active.
     *
     * @return boolean
     */
    public function isMobiliteActive(Mobilite $mobilite)
    {
        foreach ($this->mobilite as $m) {
            if($m->getId() === $mobilite->getId()) {
                return true;
            }
        }
        return false;
    }
    /**
     * @inheritDoc
     */
    public function getResourceId()
    {
        // TODO: Implement getResourceId() method.
    }

    /**
     * Get code.
     *
     * @return string
     */
    public function getCode(): ?string
    {
        return $this->codeElp;
    }

    public function getNote(Inscription $inscription)
    {
        $note = null;
        foreach ($this->inscriptionCours as $ic) {
            if($ic->getInscription()->getId() === $inscription->getId()) {
                return $ic->getNote();
            }
        }
        return null;
    }
}
