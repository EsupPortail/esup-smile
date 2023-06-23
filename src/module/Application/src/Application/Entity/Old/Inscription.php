<?php

namespace Application\Entity;

use UnicaenUtilisateur\Entity\Db\User;
use UnicaenUtilisateur\Entity\Db\UserInterface;

/**
 * Inscription
 */
class Inscription
{
    /**
     * @var string|null
     */
    private $firstname;

    /**
     * @var string|null
     */
    private $lastname;

    /**
     * @var \DateTime|null
     */
    private $birthdate;

    /**
     * @var string|null
     */
    private $esi;

    /**
     * @var string|null
     */
    private $city;

    /**
     * @var string|null
     */
    private $postalcode;

    /**
     * @var string|null
     */
    private $street;

    /**
     * @var int|null
     */
    private $numstreet;

    /**
     * @var bool|null
     */
    private $firstmobilite;

    /**
     * @var bool|null
     */
    private $handicap;

    /**
     * @var string|null
     */
    private $mailreferent;

    /**
     * @var string|null
     */
    private $status;

    /**
     * @var string|null
     */
    private $statusLibelle;

    /**
     * @var int
     */
    private $id;

    /**
     * @var User
     */
    private $user;

    /**
     * @var \Application\Entity\Step
     */
    private $step;

    /**
     * @var \Application\Entity\Mobilite
     */
    private $mobilite;

    /**
     * @var \Application\Entity\Etablissement
     */
    private $etablissement;

    /**
     * @var \Application\Entity\Pays
     */
    private $diplomepays;


    /**
     * Set firstname.
     *
     * @param string|null $firstname
     *
     * @return Inscription
     */
    public function setFirstname($firstname = null)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname.
     *
     * @return string|null
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname.
     *
     * @param string|null $lastname
     *
     * @return Inscription
     */
    public function setLastname($lastname = null)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname.
     *
     * @return string|null
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set birthdate.
     *
     * @param \DateTime|null $birthdate
     *
     * @return Inscription
     */
    public function setBirthdate($birthdate = null)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate.
     *
     * @return \DateTime|null
     */
    public function getBirthdate(): ?\DateTime
    {
        return $this->birthdate;
    }

    /**
     * Set esi.
     *
     * @param string|null $esi
     *
     * @return Inscription
     */
    public function setEsi($esi = null)
    {
        $this->esi = $esi;

        return $this;
    }

    /**
     * Get esi.
     *
     * @return string|null
     */
    public function getEsi()
    {
        return $this->esi;
    }

    /**
     * Set city.
     *
     * @param string|null $city
     *
     * @return Inscription
     */
    public function setCity($city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city.
     *
     * @return string|null
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set postalcode.
     *
     * @param string|null $postalcode
     *
     * @return Inscription
     */
    public function setPostalcode($postalcode = null)
    {
        $this->postalcode = $postalcode;

        return $this;
    }

    /**
     * Get postalcode.
     *
     * @return string|null
     */
    public function getPostalcode()
    {
        return $this->postalcode;
    }

    /**
     * Set street.
     *
     * @param string|null $street
     *
     * @return Inscription
     */
    public function setStreet($street = null)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street.
     *
     * @return string|null
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set numstreet.
     *
     * @param int|null $numstreet
     *
     * @return Inscription
     */
    public function setNumstreet($numstreet = null)
    {
        $this->numstreet = $numstreet;

        return $this;
    }

    /**
     * Get numstreet.
     *
     * @return int|null
     */
    public function getNumstreet()
    {
        return $this->numstreet;
    }

    /**
     * Set firstmobilite.
     *
     * @param bool|null $firstmobilite
     *
     * @return Inscription
     */
    public function setFirstmobilite($firstmobilite = null)
    {
        $this->firstmobilite = $firstmobilite;

        return $this;
    }

    /**
     * Get firstmobilite.
     *
     * @return bool|null
     */
    public function getFirstmobilite()
    {
        return $this->firstmobilite;
    }

    /**
     * Set handicap.
     *
     * @param bool|null $handicap
     *
     * @return Inscription
     */
    public function setHandicap($handicap = null)
    {
        $this->handicap = $handicap;

        return $this;
    }

    /**
     * Get handicap.
     *
     * @return bool|null
     */
    public function getHandicap()
    {
        return $this->handicap;
    }

    /**
     * Set mailreferent.
     *
     * @param string|null $mailreferent
     *
     * @return Inscription
     */
    public function setMailreferent($mailreferent = null)
    {
        $this->mailreferent = $mailreferent;

        return $this;
    }

    /**
     * Get mailreferent.
     *
     * @return string|null
     */
    public function getMailreferent()
    {
        return $this->mailreferent;
    }

    /**
     * Set status.
     *
     * @param string|null $status
     *
     * @return Inscription
     */
    public function setStatus($status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return string|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set statusLibelle.
     *
     * @param string|null $statusLibelle
     *
     * @return Inscription
     */
    public function setStatusLibelle($statusLibelle = null)
    {
        $this->statusLibelle = $statusLibelle;

        return $this;
    }

    /**
     * Get statusLibelle.
     *
     * @return string|null
     */
    public function getStatusLibelle()
    {
        return $this->statusLibelle;
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
     * Set user.
     *
     * @param User|null $user
     *
     * @return Inscription
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Set Step.
     *
     * @param \Application\Entity\Step|null $step
     *
     * @return Inscription
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
     * Set mobilite.
     *
     * @param \Application\Entity\Mobilite|null $mobilite
     *
     * @return Inscription
     */
    public function setMobilite(\Application\Entity\Mobilite $mobilite = null)
    {
        $this->mobilite = $mobilite;

        return $this;
    }

    /**
     * Get mobilite.
     *
     * @return \Application\Entity\Mobilite|null
     */
    public function getMobilite()
    {
        return $this->mobilite;
    }

    /**
     * Set etablissement.
     *
     * @param \Application\Entity\Etablissement|null $etablissement
     *
     * @return Inscription
     */
    public function setEtablissement(\Application\Entity\Etablissement $etablissement = null)
    {
        $this->etablissement = $etablissement;

        return $this;
    }

    /**
     * Get etablissement.
     *
     * @return \Application\Entity\Etablissement|null
     */
    public function getEtablissement()
    {
        return $this->etablissement;
    }

    /**
     * Set diplomepays.
     *
     * @param \Application\Entity\Pays|null $diplomepays
     *
     * @return Inscription
     */
    public function setDiplomepays(\Application\Entity\Pays $diplomepays = null)
    {
        $this->diplomepays = $diplomepays;

        return $this;
    }

    /**
     * Get diplomepays.
     *
     * @return \Application\Entity\Pays|null
     */
    public function getDiplomepays()
    {
        return $this->diplomepays;
    }
}
