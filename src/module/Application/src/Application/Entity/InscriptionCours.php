<?php

namespace Application\Entity;

use Doctrine\Common\Collections\Collection;

class InscriptionCours
{
    /**
     * @var integer
     */
    private int $id;

    /**
     * @var Cours
     */
    private Cours $cours;

    /**
     * @var Inscription
     */
    private Inscription $inscription;

    /**
     * @var string|null
     */
    private ?string $note;

    public function getId(): int
    {
        return $this->id;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): void
    {
        $this->note = $note;
    }

    public function getCours(): Cours
    {
        return $this->cours;
    }

    public function setCours(Cours $cours): void
    {
        $this->cours = $cours;
    }

    public function getInscription(): Inscription
    {
        return $this->inscription;
    }

    public function setInscription(Inscription $inscription): void
    {
        $this->inscription = $inscription;
    }


}