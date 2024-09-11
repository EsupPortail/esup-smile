<?php

namespace Application\Entity;

/**
 * Stepmessage
 */
class Stepmessage
{
    /**
     * @var string
     */
    private $libelle;

    /**
     * @var string|null
     */
    private $currentstatus;

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var \DateTime|null
     */
    private $date;

    /**
     * @var bool
     */
    private $showed;

    /**
     * @var int
     */
    private $id;

    /**
     * @var \Application\Entity\Step
     */
    private $step;

    /**
     * @var \Application\Entity\Inscription
     */
    private $inscription;

    /**
     * @var \Application\Entity\Inscription
     */
    private $validator;

    /**
     * Set libelle.
     *
     * @param string $libelle
     *
     * @return Stepmessage
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
     * Set currentstatus.
     *
     * @param string|null $currentstatus
     *
     * @return Stepmessage
     */
    public function setCurrentstatus($currentstatus = null)
    {
        $this->currentstatus = $currentstatus;

        return $this;
    }

    /**
     * Get currentstatus.
     *
     * @return string|null
     */
    public function getCurrentstatus()
    {
        return $this->currentstatus;
    }

    /**
     * Set type.
     *
     * @param string|null $type
     *
     * @return Stepmessage
     */
    public function setType($type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set date.
     *
     * @param \DateTime|null $date
     *
     * @return Stepmessage
     */
    public function setDate($date = null)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime|null
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set date.
     *
     * @param bool|null $showed
     * @return Stepmessage
     */
    public function setShowed($showed = null)
    {
        $this->showed = $showed;

        return $this;
    }

    /**
     * Get date.
     *
     * @return bool|null
     */
    public function getShowed()
    {
        return $this->showed;
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
     * Set step.
     *
     * @param \Application\Entity\Step|null $step
     *
     * @return Stepmessage
     */
    public function setStep(\Application\Entity\Step $step = null)
    {
        $this->step = $step;

        return $this;
    }

    /**
     * Get step.
     *
     * @return \Application\Entity\Step|null
     */
    public function getStep()
    {
        return $this->step;
    }
    
    /**
     * Set inscription.
     *
     * @param \Application\Entity\Inscription|null $inscription
     *
     * @return Stepmessage
     */
    public function setInscription(\Application\Entity\Inscription $inscription = null)
    {
        $this->inscription = $inscription;

        return $this;
    }

    /**
     * Get inscription.
     *
     * @return \Application\Entity\Inscription|null
     */
    public function getInscription()
    {
        return $this->inscription;
    }

    /**
     * Set validator.
     *
     * @param \UnicaenUtilisateur\Entity\Db\User|null $validator
     *
     * @return Stepmessage
     */
    public function setValidator(\UnicaenUtilisateur\Entity\Db\User $validator = null)
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Get validator.
     *
     * @return \UnicaenUtilisateur\Entity\Db\User|null
     */
    public function getValidator()
    {
        return $this->validator;
    }
}
