<?php

namespace Application\Application\Service\Dashboard;

use Application\Service\Dashboard\DashboardService;
use Laminas\Authentication\AuthenticationService;

/**
 * Trait ComposanteServiceAwareTrait
 *
 * @package Application\Application\Service\Composante
 */
Trait DashboardServiceAwareTrait
{
    /** @var DashboardService */
    protected DashboardService $dashboardService;

    /**
     * @return DashboardService
     */
    public function getDashboardService(): DashboardService
    {
        return $this->dashboardService;
    }

    /**
     * @param DashboardService $dashboardService
     */
    public function setDashboardService(DashboardService $dashboardService): void
    {
        $this->dashboardService = $dashboardService;
    }

}