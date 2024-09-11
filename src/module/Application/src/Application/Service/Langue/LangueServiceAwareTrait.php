<?php

namespace Application\Application\Service\Langue;

use Application\Service\Langue\LangueService;
use Laminas\Authentication\AuthenticationService;
use UnicaenUtilisateur\Service\Role\RoleService;

/**
 * Trait LangueServiceAwareTrait
 * @package Application\Application\Service\Langue
 */
Trait LangueServiceAwareTrait
{
    /** @var LangueService */
    protected LangueService $langueService;

    /**
     * @return LangueService
     */
    public function getLangueService(): LangueService
    {
        return $this->langueService;
    }

    /**
     * @param LangueService $langueService
     */
    public function setLangueService(LangueService $langueService): void
    {
        $this->langueService = $langueService;
    }

}