<?php

namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use UnicaenUtilisateur\Entity\Db\Role;
use UnicaenUtilisateur\Entity\Db\User;


class ComposanteGroupe
{

    /**
     * @var string|null
     */
    private ?string $libelle;

    /**
     * @var int
     */
    private $id;

    /**
     * @var ?Collection
     */
    private ?Collection $composantes;

    /**
     * @var ?Collection
     */
    private ?Collection $users;

    /**
     * @var ?Collection
     */
    private ?Collection $roles;

    public function __construct() {
        $this->users = new ArrayCollection();
    }

    // getters and setters
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): ComposanteGroupe
    {
        $this->libelle = $libelle;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): ComposanteGroupe
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getComposantes(): Collection
    {
        return $this->composantes;
    }

    /**
     * @return array
     */
    public function getComposantesArray(): array
    {
        /**
         * @var Composante $c
         */
        $array = [];
        foreach ($this->composantes as $c) {
            $array[] = $c->toArray();
        }
        return $array;
    }

    /**
     * @param Collection $composantes
     *
     * @return ComposanteGroupe
     */
    public function setComposantes(Collection $composantes): ComposanteGroupe
    {
        $this->composantes = $composantes;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    /**
     * @param Collection $roles
     *
     * @return ComposanteGroupe
     */
    public function setRoles(Collection $roles): ComposanteGroupe
    {
        $this->roles = $roles;
        return $this;
    }

    public function addRole(Role $role): ComposanteGroupe
    {
        $this->roles[] = $role;
        return $this;
    }

    public function addComposante(Composante $composante): ComposanteGroupe
    {
        $this->composantes[] = $composante;
        return $this;
    }

    /**
     * @param Collection $users
     *
     * @return ComposanteGroupe
     */
    public function setUsers(Collection $users): ComposanteGroupe
    {
        $this->users = $users;
        return $this;
    }

    public function addUser(User $user): ComposanteGroupe
    {
        $this->users[] = $user;
        return $this;
    }

    public function removeUser(User $user): ComposanteGroupe
    {
        $this->users[] = $user;
        return $this;
    }

    public function getUsers(): ?Collection
    {
        return $this->users;
    }

    public function __toString(): string
    {
        return $this->libelle;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'libelle' => $this->libelle,
            'composantes' => $this->getComposantesArray()
        ];
    }
}