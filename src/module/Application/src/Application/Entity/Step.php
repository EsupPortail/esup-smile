<?php

namespace Application\Entity;

use UnicaenUtilisateur\Entity\Db\Role;

/**
 * Step
 */
class Step
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $libelle;

    /**
     * @var Role
     */
    private $role;

    /**
     * @var bool|null
     */
    private $status;

    /**
     * @var int
     */
    private $order;

    /**
     * @var bool
     */
    private $needValidation;

    /**
     * @var int
     */
    private $id;


    /**
     * Set code.
     *
     * @param string $code
     *
     * @return Step
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set libelle.
     *
     * @param string $libelle
     *
     * @return Step
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
     * Set status.
     *
     * @param bool|null $status
     *
     * @return Step
     */
    public function setStatus($status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return bool|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set order.
     *
     * @param int $order
     *
     * @return Step
     */
    public function setOrder($order)
    {
        $this->code = $order;

        return $this;
    }

    /**
     * Get order.
     *
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set order.
     *
     * @param bool $needValidation
     *
     * @return Step
     */
    public function setNeedValidation($needValidation)
    {
        $this->needValidation = $needValidation;

        return $this;
    }

    /**
     * Get order.
     *
     * @return bool
     */
    public function getNeedValidation()
    {
        return $this->needValidation;
    }

    /**
     * Set role.
     *
     * @param Role $role
     *
     * @return Step
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role.
     *
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
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
