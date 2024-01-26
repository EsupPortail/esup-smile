<?php

namespace Application\Entity;

/**
 * Mobilite
 */
class Mobilite
{
    /**
     * @var string
     */
    private $libelle;

    /**
     * @var int
     */
    private $id;

    /**
     * @var bool
     */
    private $active;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $cours;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $typedocuments;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cours = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set libelle.
     *
     * @param string $libelle
     *
     * @return Mobilite
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
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set active.
     *
     * @param bool $active
     *
     * @return Mobilite
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active.
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    public function toArray()
    {
        $array = [];
        if($this->getTypedocuments()) {
            foreach($this->getTypedocuments() as $td) {
                $array[] = $td->toArray();
            }
        }
        return [
            'id' => $this->id,
            'libelle' => $this->libelle,
            'active' => $this->active,
            'typeDocuments' => $array
        ];
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
     * Add cours.
     *
     * @param \Application\Entity\Cours $cours
     *
     * @return Mobilite
     */
    public function addCours(\Application\Entity\Cours $cours)
    {
        $this->cours[] = $cours;

        return $this;
    }

    /**
     * Remove cours.
     *
     * @param \Application\Entity\Cours $cours
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCours(\Application\Entity\Cours $cours)
    {
        return $this->cours->removeElement($cours);
    }

    /**
     * Get cours.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCours()
    {
        return $this->cours;
    }

    /**
     * Add cours.
     *
     * @param \Application\Entity\TypeDocument $typedocument
     *
     * @return Mobilite
     */
    public function addTypeDocument(\Application\Entity\TypeDocument $typedocument)
    {
        $this->typedocuments[] = $typedocument;

        return $this;
    }

    /**
     * Remove cours.
     *
     * @param \Application\Entity\TypeDocument $typedocument
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeTypedocument(\Application\Entity\TypeDocument $typedocument)
    {
        return $this->typedocuments->removeElement($typedocument);
    }

    /**
     * Get cours.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTypedocuments()
    {
        return $this->typedocuments;
    }
}
