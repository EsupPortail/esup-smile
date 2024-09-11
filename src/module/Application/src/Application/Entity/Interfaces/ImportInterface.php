<?php

namespace  Application\Application\Entity\Interfaces;


interface ImportInterface {

    public function isDeleted(): bool;

    public function getDeletedOn(): ?\DateTime;

    public function setDeletedOn(?\DateTime $deletedOn): void;

    public function getCreatedOn(): ?\DateTime;

    public function setCreatedOn(?\DateTime $createdOn): void;

    public function getUpdatedOn(): ?\DateTime;

    public function setUpdatedOn(?\DateTime $updatedOn): void;
}