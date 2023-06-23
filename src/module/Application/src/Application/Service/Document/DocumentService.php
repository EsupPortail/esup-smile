<?php

namespace Application\Service\Document;

use Application\Application\Service\API\CommonEntityService;
use Application\Application\Service\API\HistoEntityServiceTrait;
use Application\Entity\Document;
use Doctrine\ORM\ORMException;
use Laminas\Form\Element\DateTime;
use Laminas\Mvc\Application;
use UnicaenAuthentification\Service\UserContext;
use UnicaenUtilisateur\Entity\Db\User;
use UnicaenUtilisateur\Entity\Db\UserInterface;

class DocumentService extends CommonEntityService
{
//    use HistoEntityServiceTrait;
    /**
     * @inheritDoc
     */
    public function getEntityClass()
    {
        return Document::class;
    }

    public function create(Document $document): Document
    {
        try {
            $this->getEntityManager()->persist($document);
            $this->getEntityManager()->flush($document);
        }catch (ORMException $e) {
            throw new \RuntimeException("Oula", 0, $e);
        }

        return $document;
    }
}