<?php

namespace Message\Service\Message;

use Application\Application\Service\API\CommonEntityService;
use Application\Application\Service\Inscription\InscriptionServiceAwareTrait;
use DateTime;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Exception;
use Message\Entity\Db\Message;
use UnicaenApp\Exception\RuntimeException;
use UnicaenApp\Service\EntityManagerAwareTrait;
use UnicaenUtilisateur\Entity\Db\User;
use UnicaenUtilisateur\Service\User\UserServiceAwareTrait;

class MessageService extends CommonEntityService{
    use EntityManagerAwareTrait;
    use InscriptionServiceAwareTrait;

    /**
     * @inheritDoc
     */
    public function getEntityClass()
    {
        return Message::class;
    }

    /**
     * @param Message $message
     *
     * @return Message
     */
    public function create(Message $message): Message
    {
        try {
            $this->getEntityManager()->persist($message);
            $this->getEntityManager()->flush($message);
        } catch (ORMException $e) {
            throw new RuntimeException("Un problème s'est produit lors de la création d'un message.",0, $e);
        }
        return $message;
    }

    /**
     * @param integer $id
     * @return Message
     */
    public function getMessage($id): Message
    {
        $qb = $this->getEntityManager()->getRepository(Message::class)->createQueryBuilder('Message')
            ->andWhere('Messagerie.id = :id')
            ->setParameter('id', $id)
        ;
        try {
            $result = $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            throw new RuntimeException("Plusieurs Messages partagent le même identifiant [".$id."]", $e);
        }
        return $result;
    }

    /**
     * @param User $user
     *
     * @return Message[]
     */
    public function getMessages(User $user): array
    {
        $inscription = $this->inscriptionService->findByUser($user);
        return $this->findAllBy(['inscription' => $inscription]);
    }

    public function addMessage(Message $message)
    {
        $message->setCreatedAt(new DateTime());
        $this->create($message);
    }


}