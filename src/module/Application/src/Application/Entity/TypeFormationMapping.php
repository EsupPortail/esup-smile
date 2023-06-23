<?php

namespace Application\Entity;

/**
 * TypeFormationMapping
 */
class TypeFormationMapping
{
    /**
     * @var string
     */
    private $codeSrc;

    /**
     * @var int
     */
    private $id;

    /**
     * @var \Application\Entity\TypeFormation
     */
    private $typeFormation;

    /**
     * @var \Application\Entity\Source
     */
    private $source;


    /**
     * Set codeSrc.
     *
     * @param string $codeSrc
     *
     * @return TypeFormationMapping
     */
    public function setCodeSrc($codeSrc)
    {
        $this->codeSrc = $codeSrc;

        return $this;
    }

    /**
     * Get codeSrc.
     *
     * @return string
     */
    public function getCodeSrc()
    {
        return $this->codeSrc;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set typeFormation.
     *
     * @param \Application\Entity\TypeFormation|null $typeFormation
     *
     * @return TypeFormationMapping
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
     * Set source.
     *
     * @param \Application\Entity\Source|null $source
     *
     * @return TypeFormationMapping
     */
    public function setSource(\Application\Entity\Source $source = null)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source.
     *
     * @return \Application\Entity\Source|null
     */
    public function getSource()
    {
        return $this->source;
    }
}
