<?php

namespace  Application\Application\Entity\Traits\InterfacesImplementation;

use Application\Application\Entity\Interfaces\SourceAwareInterface;
use Application\Application\Misc\Util;
use Application\Application\Provider\Entities\CodeSourceProvider;
use UnicaenDbImport\Entity\Db\Source;

trait SourceAwareTrait
{
    /** @var Source $source */
    protected $source;

    /**
     * @return Source|null
     */
    public function getSource(): ?Source
    {
        return $this->source;
    }

    /**
     * @param Source|null $source
     */
    public function setSource(?Source $source): void
    {
        $this->source = $source;
    }

    /**
     * @var string
     */
    private $sourceCode;

    /**
     * @return string|null
     */
    public function getSourceCode(): ?string
    {
        return $this->sourceCode;
    }

    /**
     * @param string|null $sourceCode
     */
    public function setSourceCode(?string $sourceCode): void
    {
        $this->sourceCode = $sourceCode;
    }

    /** @var SourceAwareInterface $referenceEntity */
    private $referenceEntity;

    /**
     * @return SourceAwareInterface
     */
    public function getReferenceEntity(): SourceAwareInterface
    {
        if($this->referenceEntity == null){
            $this->referenceEntity = $this;
        }
        return $this->referenceEntity;
    }

    /**
     * @param SourceAwareInterface|null $referenceEntity
     */
    public function setReferenceEntity(?SourceAwareInterface $referenceEntity): void
    {
        $this->referenceEntity = $referenceEntity;
    }

    /**
     * @var bool
     */
    private $isReferenceEntity;

    /**
     * @return bool
     */
    public function isReferenceEntity(): bool
    {
        return $this->getIsReferenceEntity();
    }

}