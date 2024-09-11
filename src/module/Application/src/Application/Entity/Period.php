<?php

namespace Application\Entity;

use Doctrine\Common\Collections\Collection;

class Period {
    private int $id;
    private \DateTime $startDate;
    private \DateTime $endDate;
    private string $libelle;
    private bool $disabledInscription;
    private Calendar $calendar;

    public function getId() {
        return $this->id;
    }

    public function setStartDate(\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    public function setEndDate(\DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    public function setLibelle(string $libelle): void
    {
        $this->libelle = $libelle;
    }

    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function setDisabledInscription(bool $disabledInscription): void
    {
        $this->disabledInscription = $disabledInscription;
    }

    public function getDisabledInscription(): bool
    {
        return $this->disabledInscription;
    }

    public function setCalendar(Calendar $calendar): void
    {
        $this->calendar = $calendar;
    }

    public function getCalendar(): Calendar
    {
        return $this->calendar;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'startDate' => $this->getStartDate()->format('Y-m-d'),
            'endDate' => $this->getEndDate()->format('Y-m-d'),
            'disabledInscription' => $this->getDisabledInscription(),
            'libelle' => $this->getLibelle(),
            'calendar' => $this->getCalendar()->getId(),
        ];
    }

}