<?php

namespace Application\Application\Service\Cours;

use Application\Application\Service\API\CommonEntityService;
use Application\Application\Service\API\HistoEntityServiceTrait;
use Application\Application\Service\API\HistoServiceInterface;
use Application\Application\Service\API\SourceEntityServiceTrait;
use Application\Application\Service\Formation\FormationServiceAwareTrait;
use  Application\Entity\Cours;
use Application\Entity\Formation;
use Application\Entity\Mobilite;

/**
 * Class CoursService
 * @package Application\Application\Service\Cours
 */
class CoursService extends CommonEntityService implements HistoServiceInterface
{
    use HistoEntityServiceTrait;
    use SourceEntityServiceTrait;
    use FormationServiceAwareTrait;

    /** @return string */
    public function getEntityClass()
    {
        return Cours::class;
    }

    public function findAll()
    {
        return $this->findAllBy(['deletedOn' => null], ["libelle" => "ASC"]);
    }

    public function findAllOpenMobilite()
    {
//        return $this->findAllBy(['ouvertMobilite' => 1]);
        return $this->findAll();
    }

    public function findAllByMobilite(Mobilite $mobilite)
    {
        /**
         * @var Cours[] $cours
         */
        $yo = [];
        $cours = $this->findAllBy(['ouvertMobilite' => 1, 'deletedOn' => null]);
        foreach ($cours as $c) {
            if($c->getMobilite()) {
                foreach ($c->getMobilite() as $m) {
                    array_push($yo, $m);
                }
            }
        }
        return $cours;
    }

    public function findAllbyComposante($idComposante)
    {
        $cours = [];
        $formations = $this->formationService->findAllBy(['composante' => $idComposante]);

        /**
         * @var Formation $f
         */
        foreach ($formations as $f) {
            $c = $this->findAllBy(['formation' => $f->getId(), 'deletedOn' => null]);
            $cours = array_merge($cours, $c);
        }

        return $cours;
    }

    /**
     * @param Cours[] $coursSelected
     * @param Cours   $cours
     *
     * @return bool
     */
    public function isCoursSelected($coursSelected,Cours $cours) {
        if($coursSelected) {
            foreach ($coursSelected as $cs) {
                if($cs->getId() === $cours->getId()) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Ajoute une entité
     *
     * @param Cours $cours
     * @param string $serviceEntityClass classe de l'entité
     * @return mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function add($cours, $serviceEntityClass = null)
    {
        $this->canAdd($cours, $serviceEntityClass);
        $this->setEntityHistoCreateur($cours);
        $this->setDefaultSource($cours);
        return parent::add($cours, $serviceEntityClass);
    }

//    /**
//     * Ajoute une entité
//     *
//     * @param Cours $cours
//     * @param string $serviceEntityClass classe de l'entité
//     * @return mixed
//     * @throws \Doctrine\ORM\ORMException
//     * @throws \Doctrine\ORM\OptimisticLockException
//     */
//    public function update($cours, $serviceEntityClass = null)
//    {
//        $this->canUpdate($cours, $serviceEntityClass);
//        $this->setEntityHistoModificateur($cours);
//        return parent::update($cours, $serviceEntityClass);
//    }
}