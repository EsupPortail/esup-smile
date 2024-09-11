<?php

namespace Application\Service\Step;

use Application\Application\Service\API\CommonEntityService;
use Application\Entity\Inscription;
use Application\Entity\Step;
use Application\Entity\Stepmessage;
use UnicaenUtilisateur\Entity\Db\User;

class StepMessageService extends CommonEntityService
{
//    use HistoEntityServiceTrait;
    /**
     * @inheritDoc
     */
    public function getEntityClass()
    {
        return Stepmessage::class;
    }

}