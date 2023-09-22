<?php

namespace Application\Entity;

use UnicaenUtilisateur\Entity\Db\User;

/**
 * Inscription
 */
class Inscription
{

    const STATUS_NOMINE = [1, 'Nomination'];
    const STATUS_INSCRIT = [2, 'Inscrit'];
    const STATUS_ABANDON = [3, 'Abandon'];
    const STATUS_TERMINE = [4, 'Terminé'];

    /**
     * @var string|null
     */
    private $uuid = 'uuid_generate_v4()';

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
     * @var string
     */
    private $email;

    /**
     * @var int|null
     */
    private $year;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var string|null
     */
    private $status;

    /**
     * @var string|null
     */
    private $statuslibelle;

    /**
     * @var int
     */
    private $id;

    /**
     * @var User
     */
    private $user;

    /**
     * @var \Application\Entity\Composante
     */
    private $composante;

    /**
     * @var \Application\Entity\Mobilite
     */
    private $mobilite;

    /**
     * @var \Application\Entity\Step
     */
    private $step;

    /**
     * @var \Application\Entity\Etablissement
     */
    private $etablissement;

    /**
     * @var \Application\Entity\Pays
     */
    private $diplomepays;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $formation;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $cours;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->formation = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cours = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set uuid.
     *
     * @param string|null $uuid
     *
     * @return Inscription
     */
    public function setUuid($uuid = null)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get uuid.
     *
     * @return string|null
     */
    public function getUuid()
    {
        return $this->uuid;
    }

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
    public function getBirthdate()
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
     * Get Email
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set Email
     * @param string $email
     * @return Inscription
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Set year
     * @param int $year
     * @return Inscription
     */
    public function setYear($year)
    {
        $this->year = $year;
        return $this;
    }

    /**
     * Get year
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Get createdAt
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
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
     * Set statuslibelle.
     *
     * @param string|null $statuslibelle
     *
     * @return Inscription
     */
    public function setStatuslibelle($statuslibelle = null)
    {
        $this->statuslibelle = $statuslibelle;

        return $this;
    }

    /**
     * Get statuslibelle.
     *
     * @return string|null
     */
    public function getStatuslibelle()
    {
        return $this->statuslibelle;
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
    public function getUser()
    {
        return $this->user;
    }


    /**
     * Set composante.
     *
     * @param \Application\Entity\Composante|null $composante
     *
     * @return Composante
     */
    public function setComposante(\Application\Entity\Composante $composante = null)
    {
        $this->composante = $composante;

        return $this;
    }

    /**
     * Get composante.
     *
     * @return \Application\Entity\Composante|null
     */
    public function getComposante()
    {
        return $this->composante;
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
     * Set step.
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

    /**
     * Add cours.
     *
     * @param \Application\Entity\Cours $cours
     *
     * @return Inscription
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


    public function removeAllCours(): Inscription
    {
        $this->cours->clear();
        return $this;
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
     * Add formation.
     *
     * @param \Application\Entity\Formation $formation
     *
     * @return Inscription
     */
    public function addFormation(\Application\Entity\Formation $formation)
    {
        $this->formation[] = $formation;

        return $this;
    }

    /**
     * Remove formation.
     *
     * @param \Application\Entity\Formation $formation
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeFormation(\Application\Entity\Formation $formation)
    {
        return $this->formation->removeElement($formation);
    }

    /**
     * Get formation.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormation()
    {
        return $this->formation;
    }
}
