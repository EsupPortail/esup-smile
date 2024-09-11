<?php

namespace Application\Application\Service\Formation;

use Application\Application\Service\API\CommonEntityService;
use Application\Application\Service\API\HistoEntityServiceTrait;
use Application\Application\Service\API\HistoServiceInterface;
use Application\Application\Service\API\SourceEntityServiceTrait;
use  Application\Entity\Formation;

/**
 * Class FormationService
 * @package Application\Application\Service\Formation
 */
class FormationService extends CommonEntityService implements HistoServiceInterface
{
    use HistoEntityServiceTrait;
    use SourceEntityServiceTrait;

    /** @return string */
    public function getEntityClass()
    {
        return Formation::class;
    }

    public function findAll()
    {
        return $this->findAllBy([], ["libelle" => "ASC"]);
    }

    /**
     * Ajoute une entité
     *
     * @param Formation $formation
     * @param string $serviceEntityClass classe de l'entité
     * @return mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function add($formation, $serviceEntityClass = null)
    {
        $this->canAdd($formation, $serviceEntityClass);
        $this->setEntityHistoCreateur($formation);
        $this->setDefaultSource($formation);
        return parent::add($formation, $serviceEntityClass);
    }

    /**
     * Ajoute une entité
     *
     * @param Formation $formation
     * @param string $serviceEntityClass classe de l'entité
     * @return mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update($formation, $serviceEntityClass = null)
    {
        $this->canUpdate($formation, $serviceEntityClass);
        $this->setEntityHistoModificateur($formation);
        return parent::update($formation, $serviceEntityClass);
    }
}