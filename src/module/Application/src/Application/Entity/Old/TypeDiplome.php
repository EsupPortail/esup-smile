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
 * TypeDiplome
 */
class TypeDiplome implements ResourceInterface,
    GenderAwareInterface
{
    /**
     *
     */
    const RESOURCE_ID = 'TypeDiplome';
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
        return GenderAwareInterface::MASCULIN;
    }

    use OrderAwareTrait;

    /**
     * TODO : reflexion sur l'utilité de la relation <one-to-many> : est-ce réelement utile ?
     * Constructor
     */
    public function __construct()
    {
        $this->formations = new \Doctrine\Common\Collections\ArrayCollection();
    }

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

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $formations;

    /**
     * Add formations.
     *
     * @param \Application\Entity\Formation $formations
     *
     * @return TypeDiplome
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

}
