<?php

namespace Application\Entity;

use Application\Application\Entity\Interfaces\HistoriqueAwareInterface;
use Application\Application\Entity\Interfaces\SourceAwareInterface;
use Application\Application\Entity\Interfaces\GenderAwareInterface;
use Application\Application\Entity\Traits\InterfacesImplementation\HistoriqueAwareTrait;
use Application\Application\Entity\Traits\InterfacesImplementation\SourceAwareTrait;
use DateTime;
use UnicaenUtilisateur\Entity\Db\User;
use UnicaenUtilisateur\Entity\Db\UserInterface;
use Laminas\Permissions\Acl\Resource\ResourceInterface;

/**
 * Composante
 */
class Composante implements ResourceInterface,
                            HistoriqueAwareInterface,
                            SourceAwareInterface,
                            GenderAwareInterface
{
    use HistoriqueAwareTrait;
    use SourceAwareTrait;

    const RESOURCE_ID = 'Composante';

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
    private $libelleLong;

    /**
     * @var string|null
     */
    private $acronyme;

    /**
     * @var string
     */
    private $sourceCode;

    /**
     * @var \DateTime
     */
//    private $histoCreation = 'now()';

    /**
     * @var \DateTime|null
     */
//    private $histoModification;

    /**
     * @var \DateTime|null
     */
//    private $histoDestruction;

    /**
     * @var int
     */
    private $id;

    /**
     * @var ComposanteGroupe
     */
    private ComposanteGroupe $groupe;

    /**
     * @var \Application\Entity\Source
     */
//    private $source;

    /**
     * @var User
     */
//    private $histoCreateur;

    /**
     * @var User
     */
//    private $histoModificateur;

    /**
     * @var User
     */
//    private $histoDestructeur;


    /**
     * Set code.
     *
     * @param string $code
     *
     * @return Composante
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
     * @return Composante
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
     * @return Composante
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
     * Set acronyme.
     *
     * @param string|null $acronyme
     *
     * @return Composante
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
     * @param \DateTime $histoCreation
     *
     * @return Composante
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
     * Set histoModification.
     *
     * @param \DateTime|null $histoModification
     *
     * @return Composante
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
     * Set histoDestruction.
     *
     * @param \DateTime|null $histoDestruction
     *
     * @return Composante
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
     * Get id.
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
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
     * @return null|Source
     */
    public function getSource(): null|Source
    {
        return $this->source;
    }

    /**
     * Set histoCreateur.
     *
     * @param UserInterface|null $histoCreateur
     *
     * @return Composante
     */
    public function setHistoCreateur(UserInterface $histoCreateur = null)
    {
        $this->histoCreateur = $histoCreateur;

        return $this;
    }

    /**
     * Get histoCreateur.
     *
     * @return User|null
     */
    public function getHistoCreateur()
    {
        return $this->histoCreateur;
    }

    /**
     * Set histoModificateur.
     *
     * @param UserInterface|null $histoModificateur
     *
     * @return Composante
     */
    public function setHistoModificateur(UserInterface $histoModificateur = null)
    {
        $this->histoModificateur = $histoModificateur;

        return $this;
    }

    /**
     * Get histoModificateur.
     *
     * @return UserInterface|null
     */
    public function getHistoModificateur()
    {
        return $this->histoModificateur;
    }

    /**
     * Set histoDestructeur.
     *
     * @param UserInterface|null $histoDestructeur
     *
     * @return Composante
     */
    public function setHistoDestructeur(UserInterface $histoDestructeur = null)
    {
        $this->histoDestructeur = $histoDestructeur;

        return $this;
    }

    /**
     * Get histoDestructeur.
     *
     * @return UserInterface|null
     */
    public function getHistoDestructeur()
    {
        return $this->histoDestructeur;
    }


    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $formations;

    /**
     * Add addFormation.
     *
     * @param \Application\Entity\Formation $formations
     *
     * @return Composante
     */
    public function addFormation(\Application\Entity\Formation $formations)
    {
        $this->formations[] = $formations;

        return $this;
    }

    /**
     * Remove formations.
     *
     * @param \Application\Entity\Formation $formations
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeFormation(\Application\Entity\Formation $formations)
    {
        return $this->formations->removeElement($formations);
    }

    /**
     * Get formations.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormations()
    {
        return $this->formations;
    }

    /**
     * @inheritDoc
     */
    public function getEntityGenre(): int
    {
        return GenderAwareInterface::FEMININ;
    }

    /**
     * @inheritDoc
     */
    public function getResourceId()
    {
        return self::RESOURCE_ID;
    }
}
