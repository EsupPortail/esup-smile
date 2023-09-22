<?php

namespace Application\Entity;

use Application\Application\Entity\Interfaces\GenderAwareInterface;
use Application\Application\Entity\Interfaces\HistoriqueAwareInterface;
use Application\Application\Entity\Interfaces\SourceAwareInterface;
use Application\Application\Entity\Traits\InterfacesImplementation\HistoriqueAwareTrait;
use Application\Application\Entity\Traits\InterfacesImplementation\SourceAwareTrait;
use DateTime;
use Laminas\Permissions\Acl\Resource\ResourceInterface;
use UnicaenUtilisateur\Entity\Db\User;
use UnicaenUtilisateur\Entity\Db\UserInterface;

/**
 * Formation
 */
class Formation implements ResourceInterface,
                           HistoriqueAwareInterface,
                           SourceAwareInterface,
                           GenderAwareInterface

{
    use HistoriqueAwareTrait;
    use SourceAwareTrait;


    const RESOURCE_ID = 'Formation';

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
     * @var int|null
     */
    private $typeDiplomeId;

    /**
     * @var int|null
     */
    private $niveauEtude;

    /**
     * @var bool|null
     */
    private $ouvertMobilite = true;

    /**
     * @var string|null
     */
    private $mention;

    /**
     * @var string|null
     */
    private $objectifs;

    /**
     * @var string|null
     */
    private $programme;

    /**
     * @var string|null
     */
    private $prerequisPedagogique;

    /**
     * @var string|null
     */
    private $modaliteEnseignement;

    /**
     * @var string|null
     */
    private $bibliographie;

    /**
     * @var string|null
     */
    private $contacts;

    /**
     * @var string|null
     */
    private $informationsComplementaires;

    /**
     * @var string
     */
    private $sourceCode;

    /**
     * @var DateTime
     */
    protected $histoCreation;

    /**
     * @var DateTime|null
     */
    protected $histoModification;

    /**
     * @var DateTime|null
     */
    protected $histoDestruction;

    /**
     * @var int
     */
    private $id;

    /**
     * @var \Application\Entity\TypeFormation
     */
    private $typeFormation;

    /**
     * @var \Application\Entity\DomaineFormation
     */
    private $domaineFormation;

    /**
     * @var \Application\Entity\Composante
     */
    private $composante;

    /**
     * @var \Application\Entity\Langue
     */
    private $langueEnseignement;

    /**
     * @var \UnicaenDbImport\Entity\Db\Source
     */
    protected $source;

    /**
     * @var User
     */
    protected $histoCreateur;

    /**
     * @var User
     */
    protected $histoModificateur;

    /**
     * @var User
     */
    protected $histoDestructeur;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $inscription;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->inscription = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set code.
     *
     * @param string $code
     *
     * @return Formation
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
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Set libelle.
     *
     * @param string|null $libelle
     *
     * @return Formation
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
     * @return Formation
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
     * Set typeDiplomeId.
     *
     * @param int|null $typeDiplomeId
     *
     * @return Formation
     */
    public function setTypeDiplomeId($typeDiplomeId = null)
    {
        $this->typeDiplomeId = $typeDiplomeId;

        return $this;
    }

    /**
     * Get typeDiplomeId.
     *
     * @return int|null
     */
    public function getTypeDiplomeId()
    {
        return $this->typeDiplomeId;
    }

    /** @var TypeDiplome|null $typeDiplome */
    private $typeDiplome;

    /**
     * @return TypeDiplome|null
     */
    public function getTypeDiplome(): ?TypeDiplome
    {
        return $this->typeDiplome;
    }

    /**
     * @param TypeDiplome|null $typeDiplome
     */
    public function setTypeDiplome(?TypeDiplome $typeDiplome): void
    {
        $this->typeDiplome = $typeDiplome;
    }


    /**
     * Set niveauEtude.
     *
     * @param int|null $niveauEtude
     *
     * @return Formation
     */
    public function setNiveauEtude($niveauEtude = null)
    {
        $this->niveauEtude = $niveauEtude;

        return $this;
    }

    /**
     * Get niveauEtude.
     *
     * @return int|null
     */
    public function getNiveauEtude()
    {
        return $this->niveauEtude;
    }

    /**
     * Set niveauEtude.
     *
     * @param int|null $niveauEtude
     *
     * @return Formation
     */
    public function setNiveau($niveauEtude = null)
    {
        $this->niveauEtude = $niveauEtude;

        return $this;
    }

    /**
     * Get niveauEtude.
     *
     * @return int|null
     */
    public function getNiveau()
    {
        return $this->niveauEtude;
    }

    /**
     * Set ouvertMobilite.
     *
     * @param bool|null $ouvertMobilite
     *
     * @return Formation
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
     * Set mention.
     *
     * @param string|null $mention
     *
     * @return Formation
     */
    public function setMention($mention = null)
    {
        $this->mention = $mention;

        return $this;
    }

    /**
     * Get mention.
     *
     * @return string|null
     */
    public function getMention()
    {
        return $this->mention;
    }

    /**
     * Set objectifs.
     *
     * @param string|null $objectifs
     *
     * @return Formation
     */
    public function setObjectifs($objectifs = null)
    {
        $this->objectifs = $objectifs;

        return $this;
    }

    /**
     * Get objectifs.
     *
     * @return string|null
     */
    public function getObjectifs()
    {
        return $this->objectifs;
    }

    /**
     * Set programme.
     *
     * @param string|null $programme
     *
     * @return Formation
     */
    public function setProgramme($programme = null)
    {
        $this->programme = $programme;

        return $this;
    }

    /**
     * Get programme.
     *
     * @return string|null
     */
    public function getProgramme()
    {
        return $this->programme;
    }

    /**
     * Set prerequisPedagogique.
     *
     * @param string|null $prerequisPedagogique
     *
     * @return Formation
     */
    public function setPrerequisPedagogique($prerequisPedagogique = null)
    {
        $this->prerequisPedagogique = $prerequisPedagogique;

        return $this;
    }

    /**
     * Get prerequisPedagogique.
     *
     * @return string|null
     */
    public function getPrerequisPedagogique()
    {
        return $this->prerequisPedagogique;
    }

    /**
     * Set modaliteEnseignement.
     *
     * @param string|null $modaliteEnseignement
     *
     * @return Formation
     */
    public function setModaliteEnseignement($modaliteEnseignement = null)
    {
        $this->modaliteEnseignement = $modaliteEnseignement;

        return $this;
    }

    /**
     * Get modaliteEnseignement.
     *
     * @return string|null
     */
    public function getModaliteEnseignement()
    {
        return $this->modaliteEnseignement;
    }

    /**
     * Set bibliographie.
     *
     * @param string|null $bibliographie
     *
     * @return Formation
     */
    public function setBibliographie($bibliographie = null)
    {
        $this->bibliographie = $bibliographie;

        return $this;
    }

    /**
     * Get bibliographie.
     *
     * @return string|null
     */
    public function getBibliographie()
    {
        return $this->bibliographie;
    }

    /**
     * Set contacts.
     *
     * @param string|null $contacts
     *
     * @return Formation
     */
    public function setContacts($contacts = null)
    {
        $this->contacts = $contacts;

        return $this;
    }

    /**
     * Get contacts.
     *
     * @return string|null
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Set informationsComplementaires.
     *
     * @param string|null $informationsComplementaires
     *
     * @return Formation
     */
    public function setInformationsComplementaires($informationsComplementaires = null)
    {
        $this->informationsComplementaires = $informationsComplementaires;

        return $this;
    }

    /**
     * Get informationsComplementaires.
     *
     * @return string|null
     */
    public function getInformationsComplementaires()
    {
        return $this->informationsComplementaires;
    }

    /**
     * Set sourceCode.
     *
     * @param string $sourceCode
     *
     * @return Formation
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
        return $this->sourceCode;
    }

    /**
     * Set histoCreation.
     *
     * @param DateTime $histoCreation
     *
     * @return Formation
     */
    public function setHistoCreation($histoCreation)
    {
        $this->histoCreation = $histoCreation;

        return $this;
    }

    /**
     * Get histoCreation.
     *
     * @return DateTime
     */
    public function getHistoCreation()
    {
        return $this->histoCreation;
    }

    /**
     * Set histoModification.
     *
     * @param DateTime|null $histoModification
     *
     * @return Formation
     */
    public function setHistoModification($histoModification = null)
    {
        $this->histoModification = $histoModification;

        return $this;
    }

    /**
     * Get histoModification.
     *
     * @return DateTime|null
     */
    public function getHistoModification()
    {
        return $this->histoModification;
    }

    /**
     * Set histoDestruction.
     *
     * @param DateTime|null $histoDestruction
     *
     * @return Formation
     */
    public function setHistoDestruction($histoDestruction = null)
    {
        $this->histoDestruction = $histoDestruction;

        return $this;
    }

    /**
     * Get histoDestruction.
     *
     * @return DateTime|null
     */
    public function getHistoDestruction()
    {
        return $this->histoDestruction;
    }

    /**
     * Get id.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set typeFormation.
     *
     * @param \Application\Entity\TypeFormation|null $typeFormation
     *
     * @return Formation
     */
    public function setTypeFormation(\Application\Entity\TypeFormation $typeFormation = null)
    {
        $this->typeFormation = $typeFormation;

        return $this;
    }

    /**
     * Get typeFormation.
     *
     * @return \Application\Entity\TypeFormation|null
     */
    public function getTypeFormation()
    {
        return $this->typeFormation;
    }

    /**
     * Set domaineFormation.
     *
     * @param \Application\Entity\DomaineFormation|null $domaineFormation
     *
     * @return Formation
     */
    public function setDomaineFormation(\Application\Entity\DomaineFormation $domaineFormation = null)
    {
        $this->domaineFormation = $domaineFormation;

        return $this;
    }

    /**
     * Get domaineFormation.
     *
     * @return \Application\Entity\DomaineFormation|null
     */
    public function getDomaineFormation()
    {
        return $this->domaineFormation;
    }

    /**
     * Set composante.
     *
     * @param \Application\Entity\Composante|null $composante
     *
     * @return Formation
     */
    public function setComposante(\Application\Entity\Composante $composante = null)
    {
        $this->composante = $composante;

        return $this;
    }

    /**
     * Get composante.
     *
     * @return \Application\Entity\Composante|null
     */
    public function getComposante()
    {
        return $this->composante;
    }

    /**
     * Set langueEnseignement.
     *
     * @param \Application\Entity\Langue|null $langueEnseignement
     *
     * @return Formation
     */
    public function setLangueEnseignement(\Application\Entity\Langue $langueEnseignement = null)
    {
        $this->langueEnseignement = $langueEnseignement;

        return $this;
    }

    /**
     * Get langueEnseignement.
     *
     * @return \Application\Entity\Langue|null
     */
    public function getLangueEnseignement()
    {
        return $this->langueEnseignement;
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
     * Set histoCreateur.
     *
     * @param UserInterface|null $histoCreateur
     *
     * @return Formation
     */
    public function setHistoCreateur(UserInterface $histoCreateur = null)
    {
        $this->histoCreateur = $histoCreateur;

        return $this;
    }

    /**
     * Get histoCreateur.
     *
     * @return User
     */
    public function getHistoCreateur(): User
    {
        return $this->histoCreateur;
    }

    /**
     * Set histoModificateur.
     *
     * @param UserInterface|null $histoModificateur
     *
     * @return void
     */
    public function setHistoModificateur(UserInterface $histoModificateur = null): void
    {
        $this->histoModificateur = $histoModificateur;
    }

    /**
     * Get histoModificateur.
     *
     * @return ?User
     */
    public function getHistoModificateur(): ?User
    {
        return $this->histoModificateur;
    }

    /**
     * Set histoDestructeur.
     *
     * @param UserInterface|null $histoDestructeur
     *
     * @return void
     */
    public function setHistoDestructeur(UserInterface $histoDestructeur = null): void
    {
        $this->histoDestructeur = $histoDestructeur;
    }

    /**
     * Get histoDestructeur.
     *
     * @return User|null
     */
    public function getHistoDestructeur()
    {
        return $this->histoDestructeur;
    }

    /**
     * Add inscription.
     *
     * @param \Application\Entity\Inscription $inscription
     *
     * @return Formation
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
     * @inheritDoc
     */
    public function getResourceId()
    {
        return self::RESOURCE_ID;
    }

    /**
     * @inheritDoc
     */
    public function getEntityGenre(): int
    {
        return GenderAwareInterface::FEMININ;
    }

    public function isOuvertMobilite(): bool
    {
        return (bool)$this->ouvertMobilite;
    }
}
