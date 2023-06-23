<?php


namespace Application\Application\Service\API;

;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use UnicaenApp\Service\EntityManagerAwareInterface;
use UnicaenApp\Service\EntityManagerAwareTrait;

abstract class CommonEntityService
    implements
    EntityServiceInterface,
    EntityManagerAwareInterface
{
    use EntityManagerAwareTrait;

    /**
     * EntityRepository
     *
     * @var EntityRepository
     */
    private $repository;

    /**
     * Retourne la classe de l'entité courante
     *
     * @return string
     */
    abstract public function getEntityClass();

    /**
     * Retourne le repository de l'entité courante
     *
     * @return EntityRepository
     */
    public function getEntityRepository()
    {
        if (!$this->repository) {
            $this->repository = $this->getEntityManager()->getRepository($this->getEntityClass());
        }

        return $this->repository;
    }

    /**
     * Retourne une nouvelle instance de l'entité courante
     *
     * @return mixed
     */
    public function getEntityInstance($name = null)
    {
        $class = ($name) ?: $this->getEntityClass();
        return new $class;
    }

    /**
     * Initialise une requête
     *
     * @param string $alias Alias d'entité
     * @return QueryBuilder
     */
    public function initQueryBuilder($alias)
    {
        return $this->getEntityRepository()->createQueryBuilder($alias);
    }

    /**
     * Proxy method.
     *
     * @see EntityManager::beginTransaction()
     */
    public function beginTransaction()
    {
        $this->getEntityManager()->beginTransaction();
    }

    /**
     * Proxy method.
     *
     * @see EntityManager::commit()
     */
    public function commit()
    {
        $this->getEntityManager()->commit();
    }

    /**
     * Proxy method.
     *
     * @see EntityManager::rollback()
     */
    public function rollback()
    {
        $this->getEntityManager()->rollback();
    }

    /**
     * Exécute une requête
     *
     * @param string $sql
     * @param array $params
     * @return \Doctrine\DBAL\Driver\ResultStatement
     * @throws \Doctrine\DBAL\DBALException
     */
    public function exec($sql, $params = [])
    {
        return $this->getEntityManager()->getConnection()->executeQuery($sql, $this->prepareParams($params));
    }


    /**
     * Préparation des paramètres à passer à la requête
     *
     * @param array $params
     * @return array
     */
    private function prepareParams($params = [])
    {
        if (null == $params) $params = [];
        foreach ($params as $n => $v) {
            if (is_object($v) && method_exists($v, 'getId')) {
                $params[$n] = $v->getId();
            }
        }

        return $params;
    }

    /**
     * Cherche une entité par son Id
     *
     * @param int $id identifiant de l'entité
     * @return null|mixed
     */
    public function find($id)
    {
        return (null != $id)
            ? $this->getEntityRepository()->find($id)
            : null;
    }

    /**
     * Cherche toutes les instances de l'entité
     *
     * @return array
     */
    public function findAll()
    {
        $result = $this->getEntityRepository()->findAll();
        return $this->getList($result);
    }

    /**
     * @param array $criteria
     * @param array $orderBy
     * @return array
     */
    public function findAllBy($criteria = [], $orderBy = [])
    {
        $result = $this->getEntityRepository()->findBy($criteria, $orderBy);
        return $this->getList($result);
    }

    /**
     * @param array $criteria
     * @param array $orderBy
     * @return null|mixed
     */
    public function findOneBy($criteria = [], $orderBy = [])
    {
        return $this->getEntityRepository()->findOneBy($criteria, $orderBy);
    }

    /**
     * Cherche une entité selon un attribut et sa valeur.
     * Possibilité de rendre la recherche insensible à la casse.
     *
     * @param mixed $value valeur de l'attribut
     * @param bool $caseSensitive sensibilité à la casse
     * @return mixed|object|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByAttribute($value, $attribute, $caseSensitive = false)
    {
        if (!$value) {
            return null;
        }
        if (is_numeric($value)) {
            return $this->getEntityRepository()->findOneBy([$attribute => $value]);
        }
        if ($caseSensitive) {
            return $this->getEntityRepository()->findOneBy([$attribute => $value]);
        }
        $qb = $this->getEntityRepository()->createQueryBuilder($alias = 'st');
        $qb->andWhere($qb->expr()->eq($qb->expr()->upper("$alias.$attribute"), $qb->expr()->upper(":$attribute")))
            ->setParameter($attribute, $value);
        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * Retourne la liste des valeurs distinctes d'un attribut d'une entité
     *
     * @return array
     */
    public function getAttributeValues($attr)
    {
        $liste = [];

        if (null == $attr) {
            return $liste;
        }

        $qb = $this->initQueryBuilder($alias = 'st');
        $qb
            ->select("$alias.$attr")
            ->distinct()
            ->addOrderBy("$alias.$attr", 'asc');

        foreach ($qb->getQuery()->getArrayResult() as $item) {
            $liste[$item[$attr]] = $item[$attr];
        }

        return $liste;
    }

    /**
     * Retourne une liste d'entités sous forme d'un tableau associatif dont les clés
     * sont les id des entités et les valeurs correspondent au champ choisi
     *
     * @param array $entities liste des entités
     * @param string $key attribut utilisé comme clé
     * @param string $value attribut utilisé pour les valeurs
     * @param string $entityClass classe de l'entité
     * @return array
     */
    public function getListForSelect($entities, $key = 'id', $value = 'libelle', $entityClass = null)
    {
        $entityClass = $entityClass ?: $this->getEntityClass();

        foreach ($entities as $entity) {
            if ($entity instanceof $entityClass
                && method_exists($entity, $kgetter = 'get' . ucfirst($key))
                && method_exists($entity, $vgetter = 'get' . ucfirst($value))) {
                $result[$entity->$kgetter()] = $entity->$vgetter();
            }
        }

        return (array)$result;
    }

    /**
     * Retourne une liste d'entités sous forme d'un tableau associatif dont
     * les clés sont les id des entités et les valeurs les entités elles-mêmes
     *
     * @param array $entities liste des entités
     * @param string $key attribut utilisé comme clé
     * @param string $entityClass classe de l'entité
     * @return array
     */
    public function getList($entities, $key = 'id', $entityClass = null)
    {
        $entityClass = $entityClass ?: $this->getEntityClass();
        $result = [];
        foreach ($entities as $entity) {
            if ($entity instanceof $entityClass
                && method_exists($entity, $kgetter = 'get' . ucfirst($key))) {
                $result[$entity->$kgetter()] = $entity;
            }
        }
        return (array)$result;
    }

    /** Fonction de controle sur les actions (pour simplifier la réutilisation des controles de bases en cas de surcharge des fonctions d'ajout/Modification ... */
    /**
     * @param mixed $entity
     * @param string $serviceEntityClass classe de l'entité
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function canAdd($entity, $serviceEntityClass = null) : bool
    {
        if (!$serviceEntityClass) $serviceEntityClass = $this->getEntityClass();
        if (!isset($entity)) {
            throw new \RuntimeException("L'entité à ajouter n'a pas été transmise.");
        }
        if (!$this->isInstanceOfEntityClass($entity, $serviceEntityClass)) {
            throw new \RuntimeException("L'entité transmise doit être de la classe $serviceEntityClass.");
        }
        return true;
    }
    /**
     * @param mixed $entity
     * @param string $serviceEntityClass classe de l'entité
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function canUpdate($entity, $serviceEntityClass = null) : bool
    {
        if (!$serviceEntityClass) $serviceEntityClass = $this->getEntityClass();
        if (!isset($entity)) {
            throw new \RuntimeException("L'entité à mettre à jour n'a pas été transmise.");
        }
        if (!$this->isInstanceOfEntityClass($entity, $serviceEntityClass)) {
            throw new \RuntimeException("L'entité transmise doit être de la classe $serviceEntityClass.");
        }
        return true;
    }
    /**
     * @param mixed $entity
     * @param string $serviceEntityClass classe de l'entité
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function canDelete($entity, $serviceEntityClass = null) : bool
    {
        if (!$serviceEntityClass) $serviceEntityClass = $this->getEntityClass();
        if (!isset($entity)) {
            throw new \RuntimeException("L'entité à supprimer n'a pas été transmise.");
        }
        if (!$this->isInstanceOfEntityClass($entity, $serviceEntityClass)) {
            throw new \RuntimeException("L'entité transmise doit être de la classe $serviceEntityClass.");
        }
        return true;
    }

    /**
     * Ajoute une entité
     *
     * @param mixed $entity
     * @param string $serviceEntityClass classe de l'entité
     * @return mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function add($entity, $serviceEntityClass = null)
    {
        $this->canAdd($entity, $serviceEntityClass);
        return $this->update($entity, $serviceEntityClass);
    }

    /**
     * Ajout de plusieurs entités
     *
     * @param array $entities
     * @param string $serviceEntityClass classe de l'entité
     * @return mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addMultiple($entities, $serviceEntityClass = null)
    {
        if (!$serviceEntityClass) $serviceEntityClass = $this->getEntityClass();
        foreach ($entities as $entity) {
            $this->canAdd($entity, $serviceEntityClass);
            $this->getEntityManager()->persist($entity);
        }
        if ($this->hasUnitOfWorksChange()) {
            $this->getEntityManager()->flush();
        }

        return $entities;
    }

    /**
     * Ajoute/Met à jour une entité
     *
     * @param mixed $entity
     * @param string $serviceEntityClass classe de l'entité
     * @return mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update($entity, $serviceEntityClass = null)
    {
        $this->canUpdate($entity, $serviceEntityClass);
        $this->getEntityManager()->persist($entity);
        if ($this->hasUnitOfWorksChange()) {
            $this->getEntityManager()->flush();
        }

        return $entity;
    }

    /**
     * Ajoute/Met à jour une entité
     *
     * @param array $entities
     * @param string $serviceEntityClass classe de l'entité
     * @return mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateMultiple($entities, $serviceEntityClass = null)
    {
        if (sizeof($entities) == 0) return $entities;
        foreach ($entities as $entity) {
            $this->canUpdate($entity, $serviceEntityClass);
            $this->getEntityManager()->persist($entity);
        }
        if ($this->hasUnitOfWorksChange()) {
            $this->getEntityManager()->flush();
        }

        return $entities;
    }

    /**
     * Supprime une entité
     *
     * @param mixed $entity
     * @param string $serviceEntityClass classe de l'entité
     * @return $this
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete($entity, $serviceEntityClass = null)
    {
        $this->canDelete($entity, $serviceEntityClass);
        $this->getEntityManager()->remove($entity);
        if ($this->hasUnitOfWorksChange()) {
            $this->getEntityManager()->flush();
        }
        return $this;
    }

    /**
     * Supprime une entité
     *
     * @param array $entities
     * @param string $serviceEntityClass classe de l'entité
     * @return $this
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteMultiple($entities, $serviceEntityClass = null)
    {
        if (!$serviceEntityClass) $serviceEntityClass = $this->getEntityClass();
        foreach ($entities as $entity) {
            $this->canDelete($entity, $serviceEntityClass);
            $this->getEntityManager()->remove($entity);
        }
        if ($this->hasUnitOfWorksChange()) {
            $this->getEntityManager()->flush();
        }
        return $this;
    }


    /**
     * Fonction qui vérifie que l'entité est bien de la class associée au service
     *
     * @param mixed $entity
     * @param string $serviceEntityClass classe de l'entité
     * @return bool
     */
    protected function isInstanceOfEntityClass($entity, $serviceEntityClass = null)
    {
        $entityClass = get_class($entity);
        $serviceEntityClass = $serviceEntityClass ?: $this->getEntityClass();
        return ($serviceEntityClass == $entityClass || is_subclass_of($entity, $serviceEntityClass));
    }

    //Fonction qui permet de regarder si certaines entité ont eu des changements depuis le dernier commit
    public function hasUnitOfWorksChange()
    {
        $unitOfwork = $this->getEntityManager()->getUnitOfWork();
        $unitOfwork->computeChangeSets();
        return
            sizeof($unitOfwork->getScheduledEntityInsertions()) != 0
            || sizeof($unitOfwork->getScheduledEntityUpdates()) != 0
            || sizeof($unitOfwork->getScheduledCollectionUpdates()) != 0
            || sizeof($unitOfwork->getScheduledEntityDeletions()) != 0
            || sizeof($unitOfwork->getScheduledCollectionDeletions()) != 0;
    }
}