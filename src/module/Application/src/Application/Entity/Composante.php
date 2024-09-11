<?php

namespace Application\Entity;

use Application\Application\Entity\Interfaces\HistoriqueAwareInterface;
use Application\Application\Entity\Interfaces\ImportInterface;
use Application\Application\Entity\Interfaces\SourceAwareInterface;
use Application\Application\Entity\Interfaces\GenderAwareInterface;
use Application\Application\Entity\Traits\InterfacesImplementation\HistoriqueAwareTrait;
use Application\Application\Entity\Traits\InterfacesImplementation\ImportAwareTrait;
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
                            GenderAwareInterface,
                            ImportInterface
{
    use HistoriqueAwareTrait;
    use SourceAwareTrait;
    use ImportAwareTrait;

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
     * @var ComposanteGroupe|null
     */
    private ?ComposanteGroupe $groupe;

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
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function getGroupeLibelle(): ?string
    {
        if($this->getGroupe()) {
            return $this->getGroupe()->getLibelle();
        }
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
     * @param ComposanteGroupe|null $groupe
     *
     * @return Composante
     */
    public function setGroupe(ComposanteGroupe $groupe = null)
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * Get acronyme.
     *
     * @return ComposanteGroupe|null
     */
    public function getGroupe(): ?ComposanteGroupe
    {
        return $this->groupe;
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

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'libelle' => $this->libelle,
            'code' => $this->getCode()
        ];
    }
}
