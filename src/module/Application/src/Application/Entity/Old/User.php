<?php

namespace UnicaenUtilisateur\Entity\Db;

class User extends AbstractUser
{
    /**
     * @var RoleInterface
     */
    private $lastRole;
}

