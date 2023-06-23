<?php

namespace Fichier\Service\Nature;

use Doctrine\ORM\NonUniqueResultException;
use Fichier\Entity\Db\Nature;
use UnicaenApp\Exception\RuntimeException;
use UnicaenApp\Service\EntityManagerAwareTrait;

class NatureService {
    use EntityManagerAwareTrait;

    public function getNaturesAsOptions()
    {
        $qb = $this->getEntityManager()->getRepository(Nature::class)->createQueryBuilder('nature')
            ->orderBy('nature.id');
            ;
        $result = $qb->getQuery()->getResult();

        $options = [];
        $options[null] = "Sélectionner une nature de fichier ...";
        /** @var Nature $item */
        foreach ($result as $item) {
            $options[$item->getId()] = $item->getLibelle();
        }
        return $options;
    }

    /**
     * @param integer $id
     * @return Nature
     */
    public function getNature($id)
    {
        $qb = $this->getEntityManager()->getRepository(Nature::class)->createQueryBuilder('nature')
            ->andWhere('nature.id = :id')
            ->setParameter('id', $id)
        ;
        try {
            $result = $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            throw new RuntimeException("Plusieurs Nature partagent le même identifiant [".$id."]", $e);
        }
        return $result;
    }

    /**
     * @param string $code
     * @return Nature
     */
    public function getNatureByCode($code)
    {
        $qb = $this->getEntityManager()->getRepository(Nature::class)->createQueryBuilder('nature')
            ->andWhere('nature.code = :code')
            ->setParameter('code', $code)
        ;
        try {
            $result = $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            throw new RuntimeException("Plusieurs Nature partagent le même code [".$code."]", $e);
        }
        return $result;
    }

    /** FACADE ******************************************************************************************/

    /**
     * @param string $libelle
     * @param string|null $description
     * @return Nature
     */
    public function addNature(string $libelle, ?string $description) : Nature
    {
        $code = strtoupper($libelle);
        $nature = $this->getNatureByCode($code);

        if($nature === null) {
            $nature = new Nature();
            $nature->setCode($code);
            $nature->setLibelle($libelle);
            $nature->setDescription($description);
            $this->getEntityManager()->persist($nature);
            $this->getEntityManager()->flush($nature);
        }
        return $nature;
    }
}