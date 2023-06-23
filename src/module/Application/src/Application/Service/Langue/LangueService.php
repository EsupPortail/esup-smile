<?php

namespace Application\Service\Langue;

use Application\Application\Service\API\CommonEntityService;
use Application\Entity\Langue;

class LangueService extends CommonEntityService
{
//    use HistoEntityServiceTrait;
    /**
     * @inheritDoc
     */
    public function getEntityClass()
    {
        return Langue::class;
    }
}