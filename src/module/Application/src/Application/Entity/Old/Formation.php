<?php

namespace  Application\Entity;

use Application\Application\Entity\Interfaces\GenderAwareInterface;
use Application\Application\Entity\Interfaces\HistoriqueAwareInterface;
use Application\Application\Entity\Interfaces\OrderAwareInterface;
use Application\Application\Entity\Interfaces\SourceAwareInterface;
use Application\Application\Entity\Traits\InterfacesImplementation\HistoriqueAwareTrait;
use Application\Application\Entity\Traits\InterfacesImplementation\OrderAwareTrait;
use Application\Application\Entity\Traits\InterfacesImplementation\SourceAwareTrait;
use Laminas\Permissions\Acl\Resource\ResourceInterface;

/**
 * TypeFormation
 */
class Formation implements ResourceInterface,
    HistoriqueAwareInterface,
    SourceAwareInterface,
    GenderAwareInterface
{
    /**
     *
     */
    const RESOURCE_ID = 'Formation';
    /**
     * Returns the string identifier of the Resource
     *
     * @return string
     */
    public function getResourceId()
    {
        return self::RESOURCE_ID;
    }

    public function getEntityGenre(): int
    {
        return GenderAwareInterface::FEMININ;
    }

    use HistoriqueAwareTrait;
    use SourceAwareTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @var string
     */
    private $code;

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @var string|null
     */
    private $libelle;
    /**
     * @return string|null
     */
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    /**
     * @param string|null $libelle
     */
    public function setLibelle(?string $libelle): void
    {
        $this->libelle = $libelle;
    }

    /**
     * @var string|null
     */
    private $acronyme;

    /**
     * @return string|null
     */
    public function getAcronyme(): ?string
    {
        return $this->acronyme;
    }

    /**
     * @param string|null $acronyme
     */
    public function setAcronyme(?string $acronyme): void
    {
        $this->acronyme = $acronyme;
    }

    /** @var int $niveau */
    private $niveau = 0;

    /**
     * @return int
     */
    public function getNiveau(): int
    {
        return $this->niveau;
    }

    /**
     * @param int $niveau
     */
    public function setNiveau(int $niveau): void
    {
        $this->niveau = $niveau;
    }

    /** @var boolean $ouvertMobilite */
    private $ouvertMobilite = true;

    /**
     * @return bool
     */
    public function isOuvertMobilite(): bool
    {
        return $this->ouvertMobilite;
    }

    /**
     * @param bool $ouvertMobilite
     */
    public function setOuvertMobilite(bool $ouvertMobilite): void
    {
        $this->ouvertMobilite = $ouvertMobilite;
    }

    /**
     * @var string|null
     */
    private $mention;

    /**
     * @return string|null
     */
    public function getMention(): ?string
    {
        return $this->mention;
    }

    /**
     * @param string|null $mention
     */
    public function setMention(?string $mention): void
    {
        $this->mention = $mention;
    }

    /**
     * @var string|null
     */
    private $objectifs;

    /**
     * @return string|null
     */
    public function getObjectifs(): ?string
    {
        return $this->objectifs;
    }

    /**
     * @param string|null $objectifs
     */
    public function setObjectifs(?string $objectifs): void
    {
        $this->objectifs = $objectifs;
    }

    /**
     * @var string|null
     */
    private $programme;

    /**
     * @return string|null
     */
    public function getProgramme(): ?string
    {
        return $this->programme;
    }

    /**
     * @param string|null $programme
     */
    public function setProgramme(?string $programme): void
    {
        $this->programme = $programme;
    }

    /**
     * @var string|null
     */
    private $prerequisPedagogique;

    /**
     * @return string|null
     */
    public function getPrerequisPedagogique(): ?string
    {
        return $this->prerequisPedagogique;
    }

    /**
     * @param string|null $prerequisPedagogique
     */
    public function setPrerequisPedagogique(?string $prerequisPedagogique): void
    {
        $this->prerequisPedagogique = $prerequisPedagogique;
    }

    /**
     * @var string|null
     */
    private $modaliteEnseignement;

    /**
     * @return string|null
     */
    public function getModaliteEnseignement(): ?string
    {
        return $this->modaliteEnseignement;
    }

    /**
     * @param string|null $modaliteEnseignement
     */
    public function setModaliteEnseignement(?string $modaliteEnseignement): void
    {
        $this->modaliteEnseignement = $modaliteEnseignement;
    }


    /**
     * @var string|null
     */
    private $bibliographie;

    /**
     * @return string|null
     */
    public function getBibliographie(): ?string
    {
        return $this->bibliographie;
    }

    /**
     * @param string|null $bibliographie
     */
    public function setBibliographie(?string $bibliographie): void
    {
        $this->bibliographie = $bibliographie;
    }


    /**
     * @var string|null
     */
    private $contacts;

    /**
     * @return string|null
     */
    public function getContacts(): ?string
    {
        return $this->contacts;
    }

    /**
     * @param string|null $contacts
     */
    public function setContacts(?string $contacts): void
    {
        $this->contacts = $contacts;
    }


    /**
     * @var string|null
     */
    private $informationsComplementaires;

    /**
     * @return string|null
     */
    public function getInformationsComplementaires(): ?string
    {
        return $this->informationsComplementaires;
    }

    /**
     * @param string|null $informationsComplementaires
     */
    public function setInformationsComplementaires(?string $informationsComplementaires): void
    {
        $this->informationsComplementaires = $informationsComplementaires;
    }


    /** @var TypeFormation|null $typeFormation */
    private $typeFormation;

    /**
     * @return TypeFormation|null
     */
    public function getTypeFormation(): ?TypeFormation
    {
        return $this->typeFormation;
    }

    /**
     * @param TypeFormation|null $typeFormation
     */
    public function setTypeFormation(?TypeFormation $typeFormation): void
    {
        $this->typeFormation = $typeFormation;
    }


    /** @var DomaineFormation|null $domaineFormation */
    private $domaineFormation;

    /**
     * @return DomaineFormation|null
     */
    public function getDomaineFormation(): ?DomaineFormation
    {
        return $this->domaineFormation;
    }

    /**
     * @param DomaineFormation|null $domaineFormation
     */
    public function setDomaineFormation(?DomaineFormation $domaineFormation): void
    {
        $this->domaineFormation = $domaineFormation;
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


    /** @var Composante|null $composante */
    private $composante;

    /**
     * @return Composante|null
     */
    public function getComposante(): ?Composante
    {
        return $this->composante;
    }

    /**
     * @param Composante|null $composante
     */
    public function setComposante(?Composante $composante): void
    {
        $this->composante = $composante;
    }

    /** @var Langue|null $langueEnseignement */
    private $langueEnseignement;

    /**
     * @return Langue|null
     */
    public function getLangueEnseignement(): ?Langue
    {
        return $this->langueEnseignement;
    }

    /**
     * @param Langue|null $langueEnseignement
     */
    public function setLangueEnseignement(?Langue $langueEnseignement): void
    {
        $this->langueEnseignement = $langueEnseignement;
    }
}
