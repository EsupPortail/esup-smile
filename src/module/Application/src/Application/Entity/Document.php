<?php

namespace Application\Entity;

use Fichier\Entity\Db\Fichier;
use UnicaenUtilisateur\Entity\Db\User;

class Document {

    private ?int $id=null;

    private ?Fichier $fichier=null;

    private ?User $user=null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     *
     * @return Document
     */
    public function setId(?int $id): Document
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Fichier|null
     */
    public function getFichier(): ?Fichier
    {
        return $this->fichier;
    }

    /**
     * @param Fichier|null $fichier
     *
     * @return Document
     */
    public function setFichier(?Fichier $fichier): Document
    {
        $this->fichier = $fichier;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     *
     * @return Document
     */
    public function setUser(?User $user): Document
    {
        $this->user = $user;
        return $this;
    }



}