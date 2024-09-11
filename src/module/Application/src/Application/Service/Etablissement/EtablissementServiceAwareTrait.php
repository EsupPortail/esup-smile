<?php

namespace Application\Application\Service\Etablissement;

use Application\Service\Etablissement\EtablissementService;
use Laminas\Authentication\AuthenticationService;
use UnicaenUtilisateur\Service\Role\RoleService;

/**
 * Trait EtablissementServiceAwareTrait
 * @package Application\Application\Service\Etablissement
 */
Trait EtablissementServiceAwareTrait
{
    /** @var EtablissementService */
    protected EtablissementService $EtablissementService;

    /**
     * @return EtablissementService
     */
    public function getEtablissementService(): EtablissementService
    {
        return $this->EtablissementService;
    }

    /**
     * @param EtablissementService $EtablissementService
     */
    public function setEtablissementService(EtablissementService $EtablissementService): void
    {
        $this->EtablissementService = $EtablissementService;
    }

}