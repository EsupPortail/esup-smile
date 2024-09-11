<?php

namespace Application\Application\Service\Mobilite;

use Application\Service\Mobilite\MobiliteService;

/**
 * Trait MobiliteServiceAwareTrait
 * @package Application\Application\Service\Mobilite
 */
Trait MobiliteServiceAwareTrait
{
    /** @var MobiliteService */
    protected MobiliteService $mobiliteService;

    /**
     * @return MobiliteService
     */
    public function getMobiliteService(): MobiliteService
    {
        return $this->mobiliteService;
    }

    /**
     * @param MobiliteService $mobiliteService
     */
    public function setMobiliteService(MobiliteService $mobiliteService): void
    {
        $this->mobiliteService = $mobiliteService;
    }

}