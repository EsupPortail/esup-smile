<?php


namespace Application\Application\Entity\Traits\InterfacesImplementation;


use Application\Application\Entity\Interfaces\ImportInterface;

trait ImportAwareTrait
{
    protected ?\DateTime $deletedOn = null;
    protected ?\DateTime $createdOn = null;
    protected ?\DateTime $updatedOn = null;

    public function isDeleted(): bool
    {
        return $this->deletedOn !== null;
    }

    public function getDeletedOn(): ?\DateTime
    {
        return $this->deletedOn;
    }

    public function setDeletedOn(?\DateTime $deletedOn): void
    {
        $this->deletedOn = $deletedOn;
    }

    public function getCreatedOn(): ?\DateTime
    {
        return $this->createdOn;
    }

    public function setCreatedOn(?\DateTime $createdOn): void
    {
        $this->createdOn = $createdOn;
    }

    public function getUpdatedOn(): ?\DateTime
    {
        return $this->updatedOn;
    }

    public function setUpdatedOn(?\DateTime $updatedOn): void
    {
        $this->updatedOn = $updatedOn;
    }
}