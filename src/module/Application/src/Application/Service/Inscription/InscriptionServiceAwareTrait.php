<?php

namespace Application\Application\Service\Inscription;

use Application\Service\Inscription\InscriptionService;
use Laminas\Authentication\AuthenticationService;
use UnicaenUtilisateur\Service\Role\RoleService;

/**
 * Trait ComposanteServiceAwareTrait
 * @package Application\Application\Service\Composante
 */
Trait InscriptionServiceAwareTrait
{
    /** @var InscriptionService */
    protected InscriptionService $inscriptionService;
    /** @var AuthenticationService */
    protected AuthenticationService $authenticationService;
    /** @var RoleService */
    protected RoleService $roleService;

    /**
     * @return InscriptionService
     */
    public function getInscriptionService(): InscriptionService
    {
        return $this->inscriptionService;
    }

    /**
     * @param InscriptionService $inscriptionService
     */
    public function setInscriptionService(InscriptionService $inscriptionService): void
    {
        $this->inscriptionService = $inscriptionService;
    }

    /**
     * @return AuthenticationService
     */
    public function getAuthenticationService(): AuthenticationService
    {
        return $this->authenticationService;
    }

    /**
     * @param AuthenticationService $authenticationService
     */
    public function setAuthenticationService(AuthenticationService $authenticationService): void
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * @return RoleService
     */
    public function getRoleService(): RoleService
    {
        return $this->roleService;
    }

    /**
     * @param RoleService $authenticationService
     */
    public function setRoleService(RoleService $authenticationService): void
    {
        $this->roleService = $authenticationService;
    }

}