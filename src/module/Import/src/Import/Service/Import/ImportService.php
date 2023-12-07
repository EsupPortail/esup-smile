<?php

namespace Import\Service\Import;

use Application\Application\Service\Composante\ComposanteServiceAwareTrait;
use Application\Application\Service\Cours\CoursServiceAwareTrait;
use Application\Application\Service\Formation\FormationServiceAwareTrait;
use Application\Entity\Composante;
use Application\Entity\Cours;
use Application\Entity\Formation;
use Application\Entity\Inscription;
use DateTime;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Exception;
use Import\Entity\Db\Import;
use Import\Entity\Db\Nature;
use Ramsey\Uuid\Uuid;
use UnicaenApp\Exception\RuntimeException;
use UnicaenApp\Service\EntityManagerAwareTrait;
use UnicaenUtilisateur\Service\User\UserServiceAwareTrait;
use Laminas\Mvc\Controller\AbstractActionController;

class ImportService {
    use EntityManagerAwareTrait;
    use UserServiceAwareTrait;
    use ComposanteServiceAwareTrait;
    use FormationServiceAwareTrait;
    use CoursServiceAwareTrait;


    private $path;

    /**
     * @param string $path
     * @return ImportService
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    public function importCsv($fileInfo, $entity)
    {
        // read file from post
        $fileType = $fileInfo['type'];
        $tmpName = $fileInfo['tmp_name'];
        $name = $fileInfo['name'];

        if($fileType != 'text/csv'){
            return [
                'error' => 'Le fichier doit être au format CSV'
            ];
        }
        $strToPass = "";
        switch ($entity) {
            case "composante":
                $strToPass = "code";
                break;
            case "formation":
                $strToPass = "code";
            case "cours":
                $strToPass = "code";
        }
        $failed = [];
        $success = [];
        $duplicate = [];

        $file = fopen($tmpName, 'r');
        while (($line = fgetcsv($file)) !== FALSE) {
            if($line[0] == 'code') {
                continue;
            }
            if($entity == 'composante') {
                $res = $this->addComposanteFromLine($line);
            }

            if($res[0] == 'failed') {
                $failed[] = $res[1];
            }else if($res[0] == 'duplicate') {
                $duplicate[] = $res[1];
            }else if ($res[0] == 'success') {
                $success[] = $res[1];
            }

        }
        $result = [
            'success' => $success,
            'failed' => $failed,
            'duplicate' => $duplicate,
        ];
        $result = base64_encode(serialize($result));
        return $result;
    }


    public function addComposanteFromLine($line): array
    {
        $code = $line[0];
        $libelle = $line[1];
        $libelleLong = $line[2];
        $acronyme = $line[3];

        // check if mandatory columns are not empty
        if (empty($code) || empty($libelle)) {
            return ['failed', $line];
        }
        // check if composante already exists
        $composante = $this->getComposanteService()->findOneBy(['code' => $code]);
        if ($composante) {
            return ['duplicate', $line];
        }

        $composante = new Composante();
        $composante->setCode($code);
        $composante->setLibelle($libelle);
        $composante->setLibelleLong($libelleLong);
        $composante->setAcronyme($acronyme);

        try {
            $this->getComposanteService()->add($composante);
            return ['success', $line];
        } catch (\Exception $e) {
            $line[] = $e->getMessage();
            return ['failed', $line];
        }
    }

    public function addCoursFromLine($line): array
    {
        $code = $line[0];
        $libelle = $line[1];
        $langueEnseignement = $line[2];
        $s1 = $line[3];
        $s2 = $line[4];
        $ects = $line[5];
        $volElp = $line[6];
        $ouvertMobilite = $line[7];
        $formationCode = $line[8];
        $objectif = $line[9];
        $description = $line[10];

        // check if mandatory columns are not empty
        if (empty($code) || empty($libelle) || empty($formationCode) || empty($ects)) {
            return ['failed', $line];
        }
        // check if formation already exists
        $cours = $this->getCoursService()->findOneBy(['code' => $code]);
        $formation = $this->getFormationService()->findOneBy(['code' => $formationCode]);
        if ($cours) {
            return ['duplicate', $line];
        }
        if (!$formation) {
            return ['failed', $line];
        }

        $s1 = ($s1 == 1) ? '1' : '';
        $s2 = ($s2 == 1) ? '1' : '';
        $ouvertMobilite = $ouvertMobilite == 'true';

        $cours = new Cours();
        $cours->setCodeElp($code);
        $cours->setLibelle($libelle);
        $cours->setLangueEnseignement($langueEnseignement);
        $cours->setS1($s1);
        $cours->setS2($s2);
        $cours->setEcts($ects);
        $cours->setVolElp($volElp);
        $cours->setOuvertMobilite($ouvertMobilite);
        $cours->setFormation($formation);
        $cours->setObjectif($objectif);
        $cours->setDescription($description);

        try {
            $this->getCoursService()->add($cours);
            return ['success', $line];
        } catch (\Exception $e) {
            $line[] = $e->getMessage();
            return ['failed', $line];
        }
    }

    public function addFormationFromLine($line): array
    {
        $code = $line[0];
        $libelle = $line[1];
        $acronyme = $line[2];
        $typeDiplome = $line[3];
        $niveauEtude = $line[4];
        $codeComposante = $line[5];

        // check if mandatory columns are not empty
        if (empty($code) || empty($libelle) || empty($codeComposante)) {
            return ['failed', $line];
        }
        // check if formation already exists
        $formation = $this->getFormationService()->findOneBy(['code' => $code]);
        $composante = $this->getComposanteService()->findOneBy(['code' => $codeComposante]);
        if ($formation) {
            return ['duplicate', $line];
        }
        if (!$composante) {
            return ['failed', $line];
        }

        $formation = new Formation();
        $formation->setCode($code);
        $formation->setLibelle($libelle);
        $formation->setAcronyme($acronyme);
        $formation->setTypeDiplome($typeDiplome);
        $formation->setNiveauEtude($typeDiplome);
        $formation->setComposante($composante);

        try {
            $this->getFormationService()->add($formation);
            return ['success', $line];
        } catch (\Exception $e) {
            $line[] = $e->getMessage();
            return ['failed', $line];
        }
    }

    /**
     * @param $file
     * Retreive csv data using fopen
     * @return void
     */
    public function getDataFromCsv($file)
    {
        $data = [];


    }
}