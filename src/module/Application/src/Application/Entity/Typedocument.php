<?php

namespace Application\Entity;

/**
 * Typedocument
 */
class Typedocument
{

    /**
     * @var string
     */
    private $libelle;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $mobilite;

    /**
     * @var int
     */
    private $id;

    /**
     * Set libelle.
     *
     * @param string $libelle
     *
     * @return Typedocument
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
     * Add mobilite.
     *
     * @param \Application\Entity\Mobilite $mobilite
     *
     * @return Typedocument
     */
    public function addMobilite(\Application\Entity\Mobilite $mobilite)
    {
        $this->mobilite[] = $mobilite;

        return $this;
    }

    /**
     * Remove mobilite.
     *
     * @param \Application\Entity\Mobilite $mobilite
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeMobilite(\Application\Entity\Mobilite $mobilite)
    {
        return $this->mobilite->removeElement($mobilite);
    }

    /**
     * Get mobilite.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMobilite()
    {
        return $this->mobilite;
    }

    public function toArray()
    {
        $mobiliteArray = [];
        if($this->mobilite) {
            foreach ($this->mobilite as $m) {
                $mobiliteArray[] = $m->getId();
            }
        }

        return [
            'id' => $this->id,
            'libelle' => $this->libelle,
            'mobilites' => $mobiliteArray
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
}
