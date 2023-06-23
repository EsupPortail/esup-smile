<?php

namespace  Application\Entity;

use Application\Application\Entity\Interfaces\GenderAwareInterface;
use Application\Application\Entity\Interfaces\OrderAwareInterface;
use Application\Application\Entity\Traits\InterfacesImplementation\OrderAwareTrait;
use Laminas\Permissions\Acl\Resource\ResourceInterface;

/**
 * Langue
 */
class Langue implements ResourceInterface,
    GenderAwareInterface
{
    /**
     *
     */
    const RESOURCE_ID = 'Langue';
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
    /**
     * Constructor
     */
    public function __construct()
    {
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
    private $libelleEn;

    /**
     * @return string|null
     */
    public function getLibelleEn(): ?string
    {
        return $this->libelleEn;
    }

    /**
     * @param string|null $libelleEn
     */
    public function setLibelleEn(?string $libelleEn): void
    {
        $this->libelleEn = $libelleEn;
    }

}
