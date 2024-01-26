<?php

namespace Application\Application\Service\Composante;

use Application\Application\Entity\Interfaces\HistoriqueAwareInterface;
use Application\Application\Service\API\CommonEntityService;
use Application\Application\Service\API\HistoEntityServiceTrait;
use Application\Application\Service\API\HistoServiceInterface;
use Application\Application\Service\API\SourceAwareEntityServiceInterface;
use Application\Application\Service\API\SourceEntityServiceTrait;
use  Application\Entity\Composante;
use Application\Entity\ComposanteGroupe;
use Application\Entity\Formation;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use UnicaenUtilisateur\Entity\Db\User;
use UnicaenUtilisateur\Entity\Db\UserInterface;

/**
 * Class ComposanteService
 * @package Application\Application\Service\Composante
 */
class ComposanteService extends CommonEntityService
    implements HistoServiceInterface, SourceAwareEntityServiceInterface
{
    use HistoEntityServiceTrait;
    use SourceEntityServiceTrait;

    /** @return string */
    public function getEntityClass()
    {
        return Composante::class;
    }

    public function findAll()
    {
        $composantes = $this->findAllBy([], ["libelle" => "ASC"]);
        return $composantes;
    }

    public function find($id)
    {
        /** @var Composante $composante */
        return (null != $id)
            ? $this->getEntityRepository()->find($id)
            : null;
    }

    /**
     * Récupère les composantes qui ont des formations
     *
     * @return ArrayCollection
     */
    public function findAllWithFormations(): ArrayCollection
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select("c")
            ->from("Application\Entity\Composante", "c")
            ->join("c.formations", 'f')
//            ->addSelect("COUNT(f.id) as nbFormation")
//            ->orderBy('nbFormation', 'DESC')
            ->groupBy('c.id')
            ->having("COUNT(f.id) > 0");

        $query = $qb->getQuery();
        $result = $query->execute();

        return new ArrayCollection($result);
    }

    public function findAllComposanteGroupeWithFormations(): ArrayCollection
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select("cg")
            ->from("Application\Entity\ComposanteGroupe", "cg")
            ->join("cg.composantes", 'c')
            ->join("c.formations", 'f')
//            ->addSelect("COUNT(f.id) as nbFormation")
//            ->orderBy('nbFormation', 'DESC')
            ->groupBy('cg.id')
            ->having("COUNT(f.id) > 0");

        $query = $qb->getQuery();
        $result = $query->execute();

        return new ArrayCollection($result);
    }

    /**
     * Ajoute une entité
     *
     * @param Composante $composante
     * @param string $serviceEntityClass classe de l'entité
     * @return mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function add($composante, $serviceEntityClass = null)
    {
        $this->canAdd($composante, $serviceEntityClass);
        $this->setEntityHistoCreateur($composante);
        $this->setDefaultSource($composante);
        return parent::add($composante, $serviceEntityClass);
    }

    /**
     * Ajoute une entité
     *
     * @param Composante $composante
     * @param string $serviceEntityClass classe de l'entité
     * @return mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update($composante, $serviceEntityClass = null)
    {
        $this->canUpdate($composante, $serviceEntityClass);
        $this->setEntityHistoModificateur($composante);
        return parent::update($composante, $serviceEntityClass);
    }


    /**
     * @param Composante $composante
     * @param UserInterface|null $user
     * @return void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function archiverEntity(HistoriqueAwareInterface $composante, UserInterface $user = null)
    {
        if(!isset($user)){
            $user = $this->getCurrentUser();
        }
        $composante->archiver($user);
        $this->getEntityManager()->persist($composante);
        //Archivage des formations qui sont liée
        /** @var Formation $formation */
        foreach ($composante->getFormations() as $formation){
            if(!$formation->estArchivee()){
                $formation->archiver($user);
                $this->getEntityManager()->persist($formation);
            }
        }
        $this->getEntityManager()->flush();
    }

    /** @return Composante[] */
    public function findByCode(string $code): array
    {
        /** @var  Composante[] $composante */
        return $this->getEntityRepository()->findBy(['code' => $code]);
    }

    public function getComposanteGroupes(): array
    {
        return $this->getEntityManager()->getRepository(ComposanteGroupe::class)->findAll();
    }

    public function getComposanteGroupe(int $id): mixed
    {
        return $this->getEntityManager()->getRepository(ComposanteGroupe::class)->find($id);
    }

    public function addGroup(ComposanteGroupe $group): void {
        $this->getEntityManager()->persist($group);
        $this->getEntityManager()->flush();
    }

    public function deleteGroup(int $id)
    {
        $cg = $this->getEntityManager()->getRepository(ComposanteGroupe::class)->find($id);
        $this->getEntityManager()->remove($cg);
        $this->getEntityManager()->flush();
    }

    public function updateGroup(ComposanteGroupe $composanteGroup)
    {
        $this->getEntityManager()->persist($composanteGroup);
        $this->getEntityManager()->flush();
    }

    public function getComposanteGroupesByUser(?User $user)
    {
//        return $this->getEntityManager()->getRepository(ComposanteGroupe::class)->findBy(['users' => [$user]]);
        $cgList = $this->getComposanteGroupes();
        $cgToSend = [];
        /** @var ComposanteGroupe $cg */
        foreach ($cgList as $cg) {
            $cgUsers = $cg->getUsers();
            if($cg->getUsers()->contains($user)){
                $cgToSend[] = $cg;
            }
        }
        return $cgToSend;
    }

}