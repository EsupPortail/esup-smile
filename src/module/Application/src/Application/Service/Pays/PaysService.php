<?php

namespace Application\Service\Pays;

use Application\Application\Service\API\CommonEntityService;
use Application\Entity\Pays;

class PaysService extends CommonEntityService
{

    /**
     * @inheritDoc
     */
    public function getEntityClass()
    {
        return Pays::class;
    }
}