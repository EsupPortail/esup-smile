<?php


namespace Application\Application\Service\API;

use  Application\Application\Entity\Interfaces\HistoriqueAwareInterface;
use Application\Application\Provider\Entities\CodeUserProvider;
use UnicaenApp\Service\EntityManagerAwareTrait;
use UnicaenAuthentification\Service\UserContext;
use UnicaenUtilisateur\Entity\Db\User;
use UnicaenUtilisateur\Entity\Db\UserInterface;

/** Trait permettant de gerer l'historisation des entités */
Trait HistoEntityServiceTrait
{
    use EntityManagerAwareTrait;
    /** @var UserContext $userContext */
    protected $userContext;

    /**
     * @return mixed
     */
    public function getUserContext()
    {
        return $this->userContext;
    }
    /**
     * @param mixed $userContext
     */
    public function setUserContext($userContext): void
    {
        $this->userContext = $userContext;
    }

    /** @var User */
    protected $smileUser;
    /** @return User */
    public function getSmileUser(){
        if($this->smileUser==null) {
            /** @var User */
            $this->smileUser = $this->getEntityManager()->getRepository(User::class)->findOneBy(['displayName' => CodeUserProvider::SMILE_USER_CODE]);
        }
        return $this->smileUser;
    }

    public function getCurrentUser(){
        /** @var UserInterface $currentUser */
        $user = $this->getUserContext()->getDbUser();
        if(!isset($user)){
            $user = $this->getSmileUser();
        }
        return $user;
    }

    //Si l'utilisateur créateur n'est pas spécifier, met l'utilisateur connecté ou l'application par défaut
    public function setEntityHistoCreateur(HistoriqueAwareInterface $entity, UserInterface $user = null)
    {
        if(!isset($user)){
            $user = $this->getCurrentUser();
        }
        $entity->setHistoCreateur($user);
        $entity->setHistoCreation(new \DateTime());
    }
    public function setEntityHistoModificateur(HistoriqueAwareInterface $entity, UserInterface $user = null)
    {
        if(!isset($user)){
            $user = $this->getCurrentUser();
        }
        $entity->setHistoModificateur($user);
        $entity->setHistoModification(new \DateTime());
    }

    public function setEntityHistoDestructeur(HistoriqueAwareInterface $entity, UserInterface $user = null)
    {
        if(!isset($user)){
            $user = $this->getCurrentUser();
        }
        $entity->setHistoDestructeur($user);
        $entity->setHistoDestruction(new \DateTime());
    }

    public function archiverEntity(HistoriqueAwareInterface $entity, UserInterface $user = null)
    {
        if(!isset($user)){
            $user = $this->getCurrentUser();
        }
        $entity->historiser($user);
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function restaurerEntity(HistoriqueAwareInterface $entity, UserInterface $user = null)
    {
        if(!isset($user)){
            $user = $this->getCurrentUser();
        }
        $entity->restraurer($user);
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }
}