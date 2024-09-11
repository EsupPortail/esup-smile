<?php

namespace Application\Application\Service\Pays;

use Application\Service\Pays\PaysService;

/**
 * Trait PaysServiceAwareTrait
 * @package Application\Application\Service\Pays
 */
Trait PaysServiceAwareTrait
{
    /** @var PaysService */
    protected PaysService $PaysService;

    /**
     * @return PaysService
     */
    public function getPaysService(): PaysService
    {
        return $this->PaysService;
    }

    /**
     * @param PaysService $PaysService
     */
    public function setPaysService(PaysService $PaysService): void
    {
        $this->PaysService = $PaysService;
    }

}