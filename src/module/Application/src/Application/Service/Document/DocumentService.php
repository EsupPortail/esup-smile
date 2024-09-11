<?php

namespace Application\Service\Document;

use Application\Application\Service\API\CommonEntityService;
use Application\Application\Service\API\HistoEntityServiceTrait;
use Application\Entity\Document;
use Application\Entity\Typedocument;
use Doctrine\ORM\ORMException;
use Laminas\Form\Element\DateTime;
use Laminas\Mvc\Application;
use MongoDB\BSON\Type;
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

    public function getTypeDocuments() : array
    {
        $typedocuments = $this->getEntityManager()->getRepository(Typedocument::class)->findAll();
        return $typedocuments;
    }

    public function getTypeDocumentsArray() : array
    {
        $array = [];
        $typedocuments = $this->getEntityManager()->getRepository(Typedocument::class)->findAll();

        foreach ($typedocuments as $td) {
            $array[] = $td->toArray();
        }

        return $array;
    }

    public function getTypeDocumentById(int $id) : Typedocument
    {
        $typedocument = $this->getEntityManager()->getRepository(Typedocument::class)->find($id);
        return $typedocument;
    }

    public function getTypeDocumentBy(array $criteria, ?array $order = null) : array
    {
        return $this->getEntityManager()->getRepository(Typedocument::class)->findBy($criteria, $order);
    }

    public function getTypeDocumentsByLibelle(string $libelle) : ?Typedocument
    {
        $typedocument = $this->getEntityManager()->getRepository(Typedocument::class)->findOneBy(['libelle' => $libelle]);
        return $typedocument;
    }

    public function addTypeDocument(Typedocument $td) {
        $this->getEntityManager()->persist($td);
        $this->getEntityManager()->flush();
    }

    public function removeTypeDocument(Typedocument $td) {
        $this->getEntityManager()->remove($td);
        $this->getEntityManager()->flush();
    }

    public function findAllByUserArray(User $user): array {
        $docs = $this->findAllBy(['user' => $user]);
        $array = [];
        /** @var Document $doc */
        foreach ($docs as $doc) {
            if($doc->getTypedocument()) {
                $td = $doc->getTypedocument()->getId();
            }else {
                $td = "";
            }
            $array[] = [
              'id' => $doc->getId(),
              'file' => $doc->getFichier()->getNomOriginal(),
              'tdId' => $td
            ];
        }

        return $array;
    }

    public function removeDocumentWithTypeDocument(User $user, Typedocument $td): void
    {
        $documents = $this->findAllBy(['user' => $user, 'typedocument' => $td]);
        foreach ($documents as $d) {
            $this->delete($d);
        }
    }
}