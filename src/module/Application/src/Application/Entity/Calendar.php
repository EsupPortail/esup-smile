<?php

namespace Application\Entity;

use Doctrine\Common\Collections\Collection;

class Calendar {
    private int $id;
    private int $year;
    private string $libelle;
    private Collection $periods;

    public function getId() {
        return $this->id;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setLibelle(string $libelle): void
    {
        $this->libelle = $libelle;
    }

    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function setPeriods(Collection $periods): void
    {
        $this->periods = $periods;
    }

    public function getPeriods(): Collection
    {
        return $this->periods;
    }

    public function addPeriod(Period $period): void
    {
        $this->periods->add($period);
    }

    public function removePeriod(Period $period): void
    {
        $this->periods->removeElement($period);
    }

    function toArray(): array
    {
        $periodsArray = [];
        foreach ($this->getPeriods() as $period) {
            $periodsArray[] = $period->toArray();
        }
        return [
            'id' => $this->getId(),
            'year' => $this->getYear(),
            'libelle' => $this->getLibelle(),
            'periods' => $periodsArray
        ];
    }

}