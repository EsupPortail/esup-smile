<?php

namespace Application\Entity;

use Doctrine\Common\Collections\Collection;
use UnicaenUtilisateur\Entity\Db\Role;


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
     * @var Role[]
     */
    private array $composantes;

    /**
     * @var Role[]
     */
    private array $roles;

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
     * @return Composante[]
     */
    public function getComposantes(): array
    {
        return $this->composantes;
    }

    /**
     * @param Composante[] $composantes
     *
     * @return ComposanteGroupe
     */
    public function setComposantes(array $composantes): ComposanteGroupe
    {
        $this->composantes = $composantes;
        return $this;
    }

    /**
     * @return Role[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param Role[] $roles
     *
     * @return ComposanteGroupe
     */
    public function setRoles(array $roles): ComposanteGroupe
    {
        $this->roles = $roles;
        return $this;
    }

    public function addRole(Role $role): ComposanteGroupe
    {
        $this->roles[] = $role;
        return $this;
    }

    public function removeRole(Role $role): ComposanteGroupe
    {
        $this->roles = array_filter($this->roles, function (Role $r) use ($role) {
            return $r->getId() !== $role->getId();
        });
        return $this;
    }

    public function addComposante(Composante $composante): ComposanteGroupe
    {
        $this->composantes[] = $composante;
        return $this;
    }

    public function removeComposante(Composante $composante): ComposanteGroupe
    {
        $this->composantes = array_filter($this->composantes, function (Composante $c) use ($composante) {
            return $c->getId() !== $composante->getId();
        });
        return $this;
    }

    public function __toString(): string
    {
        return $this->libelle;
    }
}