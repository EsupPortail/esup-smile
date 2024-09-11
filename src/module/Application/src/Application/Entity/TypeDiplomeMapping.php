<?php

namespace Application\Entity;

/**
 * TypeDiplomeMapping
 */
class TypeDiplomeMapping
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
     * @var \Application\Entity\TypeDiplome
     */
    private $typeDiplome;

    /**
     * @var \Application\Entity\Source
     */
    private $source;


    /**
     * Set codeSrc.
     *
     * @param string $codeSrc
     *
     * @return TypeDiplomeMapping
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
     * Set typeDiplome.
     *
     * @param \Application\Entity\TypeDiplome|null $typeDiplome
     *
     * @return TypeDiplomeMapping
     */
    public function setTypeDiplome(\Application\Entity\TypeDiplome $typeDiplome = null)
    {
        $this->typeDiplome = $typeDiplome;

        return $this;
    }

    /**
     * Get typeDiplome.
     *
     * @return \Application\Entity\TypeDiplome|null
     */
    public function getTypeDiplome()
    {
        return $this->typeDiplome;
    }

    /**
     * Set source.
     *
     * @param \Application\Entity\Source|null $source
     *
     * @return TypeDiplomeMapping
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
