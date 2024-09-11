<?php

namespace Application\Service\Etablissement;

use Application\Application\Service\API\CommonEntityService;
use Application\Application\Service\Pays\PaysServiceAwareTrait;
use Application\Entity\Etablissement;

class EtablissementService extends CommonEntityService
{
    use PaysServiceAwareTrait;
    /**
     * @inheritDoc
     */
    public function getEntityClass()
    {
        return Etablissement::class;
    }

    public function associateCountry(Etablissement $hei): Etablissement {
        if (!$hei->getPays()) {
           $code = $hei->getPaysCode();
           $country = $this->getPaysService()->findOneBy(['code' => $code]);
           if($country) {
               $hei->setPays($country);
               $this->update($hei);
           }
        }
        return $hei;
    }
}