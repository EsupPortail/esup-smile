<?php

namespace Message\Entity\Db;

use Application\Entity\Inscription;
use DateTime;
use UnicaenUtilisateur\Entity\Db\User;

class Message {

    /** @var int */
    private $id;

    /** @var Inscription */
    private Inscription $inscription;

    /** @var DateTime */
    private DateTime $createdAt;

    /** @var string */
    private string $content;

    /** @var User */
    private User $sender;

    /** @var User */
    private User $receiver;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Message
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Inscription
     */
    public function getInscription(): Inscription
    {
        return $this->inscription;
    }

    /**
     * @param Inscription $inscription
     * @return Message
     */
    public function setInscription(Inscription $inscription)
    {
        $this->inscription = $inscription;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return Message
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Message
     */
    public function setContent(string $content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return User
     */
    public function getSender(): User
    {
        return $this->sender;
    }

    /**
     * @param User $sender
     * @return Message
     */
    public function setSender(User $sender)
    {
        $this->sender = $sender;
        return $this;
    }

    /**
     * @return User
     */
    public function getReceiver(): User
    {
        return $this->receiver;
    }

    /**
     * @param User $receiver
     * @return Message
     */
    public function setReceiver(User $receiver)
    {
        $this->receiver = $receiver;
        return $this;
    }
}