<?php

namespace Application\Application\Service\Formation;

use Adapter\Service\Interfaces\ComposanteEntityAdapterServiceInterface;
use Adapter\Service\Interfaces\TypeFormationEntityAdapterServiceInterface;
use Application\Application\Entity\Interfaces\HistoriqueAwareInterface;
use Application\Application\Service\API\CommonEntityService;
use Application\Application\Service\API\HistoEntityServiceTrait;
use Application\Application\Service\API\HistoServiceInterface;
use Application\Application\Service\API\SourceAwareEntityServiceInterface;
use Application\Application\Service\API\SourceEntityServiceTrait;
use Application\Entity\Formation;
use  Application\Entity\TypeFormation;
use UnicaenUtilisateur\Entity\Db\UserInterface;

/**
 * Class TypeFormationService
 * @package Application\Application\Service\Formation
 */
class TypeFormationService extends CommonEntityService
{

    /** @return string */
    public function getEntityClass()
    {
        return TypeFormation::class;
    }

    public function findAll()
    {
        return $this->findAllBy([], ["libelle" => "ASC"]);
    }
}