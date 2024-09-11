<?php

namespace Fichier\Service\Fichier;

use DateTime;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Exception;
use Fichier\Entity\Db\Fichier;
use Fichier\Entity\Db\Nature;
use Fichier\Service\S3\S3ServiceAwareTrait;
use UnicaenApp\Exception\RuntimeException;
use UnicaenApp\Service\EntityManagerAwareTrait;
use UnicaenUtilisateur\Service\User\UserServiceAwareTrait;
use Laminas\Mvc\Controller\AbstractActionController;

class FichierService {
    use EntityManagerAwareTrait;
    use UserServiceAwareTrait;
    use S3ServiceAwareTrait;

    private string $path;
    private bool $s3;
    /**
     * @param string $path
     * @return FichierService
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    public function setS3($s3): static
    {
        $this->s3 = $s3;
        return $this;
    }

    /**
     * @param Fichier $fichier
     * @return Fichier
     */
    public function create($fichier)
    {
        $user = $this->getUserService()->getConnectedUser();
        $date = new DateTime();

        $fichier->setHistoCreateur($user);
        $fichier->setHistoCreation($date);
        $fichier->setHistoModificateur($user);
        $fichier->setHistoModification($date);

        try {
            $this->getEntityManager()->persist($fichier);
            $this->getEntityManager()->flush($fichier);
        } catch (ORMException $e) {
            throw new RuntimeException("Un problème s'est produit lors de la création d'un Fichier.",0, $e);
        }
        return $fichier;
    }

    /**
     * @param Fichier $fichier
     * @return Fichier
     */
    public function update($fichier)
    {
        $user = $this->getUserService()->getConnectedUser();
        $date = new DateTime();

        $fichier->setHistoModificateur($user);
        $fichier->setHistoModification($date);

        try {
            $this->getEntityManager()->flush($fichier);
        } catch (ORMException $e) {
            throw new RuntimeException("Un problème s'est produit lors de la mise à jour d'un Fichier.", $e);
        }
        return $fichier;
    }

    /**
     * @param Fichier $fichier
     * @return Fichier
     */
    public function historise($fichier)
    {
        $user = $this->getUserService()->getConnectedUser();
        $date = new DateTime();

        $fichier->setHistoDestructeur($user);
        $fichier->setHistoDestruction($date);

        try {
            $this->getEntityManager()->flush($fichier);
        } catch (ORMException $e) {
            throw new RuntimeException("Un problème s'est produit lors de l'historisation d'un Fichier.", $e);
        }
        return $fichier;
    }

    /**
     * @param Fichier $fichier
     * @return Fichier
     */
    public function restore($fichier)
    {
        $fichier->setHistoDestructeur(null);
        $fichier->setHistoDestruction(null);

        try {
            $this->getEntityManager()->flush($fichier);
        } catch (ORMException $e) {
            throw new RuntimeException("Un problème s'est produit lors de la restauration d'un Fichier.", $e);
        }
        return $fichier;
    }

    /**
     * @param Fichier $fichier
     * @return Fichier
     */
    public function delete($fichier)
    {

        try {
            $this->getEntityManager()->remove($fichier);
            $this->getEntityManager()->flush();
        } catch (ORMException $e) {
            throw new RuntimeException("Un problème s'est produit lors de la suppression d'un Fichier.", $e);
        }
        return $fichier;
    }

    /**
     * @param integer $id
     * @return Fichier
     */
    public function getFichier($id)
    {
        $qb = $this->getEntityManager()->getRepository(Fichier::class)->createQueryBuilder('fichier')
            ->andWhere('fichier.id = :id')
            ->setParameter('id', $id)
        ;
        try {
            $result = $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            throw new RuntimeException("Plusieurs Fichier partagent le même identifiant [".$id."]", $e);
        }
        return $result;
    }

    /**
     * @param AbstractActionController $controller
     * @param string $paramName
     * @return Fichier|null
     */
    public function getRequestedFichier(AbstractActionController $controller, string $paramName = 'fichier') : ?Fichier
    {
        $id = $controller->params()->fromRoute($paramName);
        $fichier = $this->getFichier($id);
        return $fichier;
    }

    /**
     * Crée un fichier à partir des données d'upload fournies.
     * @param array           $file Données résultant de l'upload de fichier
     * @param Nature          $nature       Version de fichier
     * @return Fichier fichier
     */
    public function createFichierFromUpload(array $file, Nature $nature)
    {
        /** @var DateTime $date */
        try {
            $date = new DateTime();
        } catch (Exception $e) {
            throw new RuntimeException("Problème lors de la récupération de la date", $e);
        }

        $fichier = null;

        if (isset($file['name'])) {

            $path = $file['tmp_name'];
            $nomFichier = $file['name'];
            $typeFichier = $file['type'];
            $tailleFichier = $file['size'];

            $uid = uniqid();

            $fichier = new Fichier();
            $fichier
                ->setId($uid)
                ->setNature($nature)
                ->setTypeMime($typeFichier)
                ->setNomOriginal($nomFichier)
                ->setTaille($tailleFichier)
            ;

            if($this->s3) {
                $pathS3 = '/fichiers/'.$this->getUserService()->getConnectedUser()->getUsername();
                $fichier->setNomStockage($pathS3.'-'.$date->format('Ymd-His')."-".$uid."-".$nature->getCode()."-".$nomFichier);
                try {
                    $this->getS3Service()->addFileToBucket($fichier->getNomStockage(), $path);
                } catch (Exception $e) {
                    throw new RuntimeException("Une erreur est survenu pendant l'upload", $e);
                }
            }else {
                $fichier->setNomStockage($date->format('Ymd-His')."-".$uid."-".$nature->getCode()."-".$nomFichier);

                $newPath = $this->path . $fichier->getNomStockage();
                $res = move_uploaded_file($path, $newPath);
                if ($res === false) {
                    throw new RuntimeException("Impossible de déplacer le fichier temporaire uploadé de $path vers $newPath");
                }
            }

            $this->create($fichier);
        }
        return $fichier;
    }

    /**
     * Retourne le contenu d'un Fichier sous la forme d'une chaîne de caractères.
     *
     * @param Fichier $fichier
     * @return string
     */
    public function fetchContenuFichier(Fichier $fichier)
    {
        $filePath = $this->path . $fichier->getNomStockage();

        if (! is_readable($filePath)) {
            throw new RuntimeException(
                "Le fichier suivant n'existe pas ou n'est pas accessible sur le serveur : " . $filePath);
        }

        $contenuFichier = file_get_contents($filePath);

        return $contenuFichier;
    }

    public function removeFichier(Fichier $fichier)
    {
        if ($this->s3) {
            $this->getS3Service()->removeFileFromBucket($fichier->getNomStockage());
        } else {
            $path = $this->path . $fichier->getNomStockage();
            $res = unlink($path);
            if ($res === false) {
                throw new RuntimeException("Un problème est survenue lors de l'effacement du fichier");
            }
        }
        $this->delete($fichier);
    }
}