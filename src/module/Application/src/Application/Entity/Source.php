<?php

namespace Application\Entity;

//use UnicaenDbImport\Entity\Db\Interfaces\SourceInterface;

/**
 * Source
 */
class Source
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $libelle;

    /**
     * @var bool
     */
    private $importable;

    /**
     * @var int
     */
    private $id;


    /**
     * Set code.
     *
     * @param string $code
     *
     * @return Source
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
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Set libelle.
     *
     * @param string $libelle
     *
     * @return Source
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle.
     *
     * @return string
     */
    public function getLibelle(): string
    {
        return $this->libelle;
    }

    /**
     * Set importable.
     *
     * @param bool $importable
     *
     * @return Source
     */
    public function setImportable($importable)
    {
        $this->importable = $importable;

        return $this;
    }

    /**
     * Get importable.
     *
     * @return bool
     */
    public function getImportable(): bool
    {
        return $this->importable;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->getLibelle();
    }
}
