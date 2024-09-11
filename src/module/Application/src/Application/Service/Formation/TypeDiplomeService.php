<?php

namespace Application\Application\Service\Formation;

use Application\Application\Entity\Interfaces\HistoriqueAwareInterface;
use Application\Application\Service\API\CommonEntityService;
use Application\Application\Service\API\HistoEntityServiceTrait;
use Application\Application\Service\API\HistoServiceInterface;
use Application\Application\Service\API\SourceEntityServiceTrait;
use Application\Entity\Formation;
use Application\Entity\TypeDiplome;
use UnicaenUtilisateur\Entity\Db\UserInterface;

/**
 * Class TypeDiplomeService
 * @package Application\Application\Service\Formation
 */
class TypeDiplomeService extends CommonEntityService
{
    /** @return string */
    public function getEntityClass()
    {
        return TypeDiplome::class;
    }

    public function findAll()
    {
        return $this->findAllBy([], ["libelle" => "ASC"]);
    }
}