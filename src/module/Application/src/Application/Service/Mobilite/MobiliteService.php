<?php

namespace Application\Service\Mobilite;

use Application\Application\Service\API\CommonEntityService;
use Application\Application\Service\API\HistoEntityServiceTrait;
use Application\Entity\Mobilite;
use Laminas\Form\Element\DateTime;
use Laminas\Mvc\Application;
use UnicaenAuthentification\Service\UserContext;
use UnicaenUtilisateur\Entity\Db\User;
use UnicaenUtilisateur\Entity\Db\UserInterface;

class MobiliteService extends CommonEntityService
{
//    use HistoEntityServiceTrait;
    /**
     * @inheritDoc
     */
    public function getEntityClass()
    {
        return Mobilite::class;
    }

    public function create(string $libelle, bool $active)
    {
        $mobilite = new \Application\Entity\Mobilite();
        if (isset($libelle)){
            $mobilite->setLibelle($libelle);
        }
        // TODO Change database to accept Active parameter
//        if (isset($active)){
//            $mobilite->setActive($active);
//        }
        $isExist = $this->findOneBy(['libelle' => $libelle]);
        if(!$isExist) {
            $this->add($mobilite);
        }
    }
}