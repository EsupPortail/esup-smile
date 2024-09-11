<?php

namespace Application\Service\Dashboard;

use Application\Application\Service\API\CommonEntityService;
use Application\Entity\Inscription;
use UnicaenAuthentification\Service\UserContext;
use UnicaenUtilisateur\Entity\Db\User;

class DashboardService
{

    protected UserContext $userContext;

    /**
     * @return UserContext
     */
    public function getUserContext(): UserContext
    {
        return $this->userContext;
    }
    /**
     * @param UserContext $userContext
     */
    public function setUserContext(UserContext $userContext): void
    {
        $this->userContext = $userContext;
    }


}