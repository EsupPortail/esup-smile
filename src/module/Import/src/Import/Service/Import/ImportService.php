<?php

namespace Import\Service\Import;

use Application\Application\Entity\Traits\Entities\TypeDiplomeAwareTrait;
use Application\Application\Entity\Traits\InterfacesImplementation\SourceAwareTrait;
use Application\Application\Service\API\SourceEntityServiceTrait;
use Application\Application\Service\Composante\ComposanteServiceAwareTrait;
use Application\Application\Service\Cours\CoursServiceAwareTrait;
use Application\Application\Service\Formation\FormationServiceAwareTrait;
use Application\Entity\Composante;
use Application\Entity\Cours;
use Application\Entity\Formation;
use Application\Entity\Inscription;
use Application\Entity\Langue;
use Application\Entity\Source;
use Application\Entity\TypeDiplome;
use Application\Entity\TypeFormation;
use DateTime;
use Doctrine\ORM\Exception\NotSupported;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Exception\ORMException;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Import\Service\MySynchro\MySynchroServiceAwareTrait;
use Laminas\Validator\Date;
use Ramsey\Uuid\Uuid;
use UnicaenApp\Exception\RuntimeException;
use UnicaenApp\Service\EntityManagerAwareTrait;
use UnicaenSynchro\Service\Synchronisation\SynchronisationServiceAwareTrait;
use UnicaenUtilisateur\Service\User\UserServiceAwareTrait;

class ImportService {
    use EntityManagerAwareTrait;
    use UserServiceAwareTrait;
    use ComposanteServiceAwareTrait;
    use FormationServiceAwareTrait;
    use CoursServiceAwareTrait;
    use TypeDiplomeAwareTrait;
    use SourceEntityServiceTrait;
    use MySynchroServiceAwareTrait;

    private array $config;

    public function setConfig(array $config): static
    {
        $this->config = $config;
        return $this;
    }

    public function importCsv($fileInfo, $entity): array|string
    {
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 600); // 10 minutes
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

        $cours = [];
        $res = [];
        $file = fopen($tmpName, 'r');
        while (($line = fgetcsv($file)) !== FALSE) {
            if($line[0] == 'code') {
                continue;
            }
            if($entity == 'composante') {
                $res = $this->addComposanteFromLine($line);
            }elseif ($entity == 'formation') {
                $res = $this->addFormationFromLine($line);
            }elseif ($entity == 'cours') {
                $cour = $this->getCourFromLine($line);
                if($cour) {
                    $cours[] = $cour;
                    $res = [
                        'success',
                        $cour
                    ];
                }else {
                    $res = ['failed', $line];
                }
            }

            if($res[0] == 'failed') {
                $failed[] = $res[1];
            }else if($res[0] == 'duplicate') {
                $duplicate[] = $res[1];
            }else if ($res[0] == 'success') {
                $success[] = $res[1];
            }

        }
        if ($entity == 'cours') {
            $nbCours = count($cours);
            $nAdded = 0;
            $chunksCours = array_chunk($cours, 100);
            foreach ($chunksCours as $cours) {
                foreach ($cours as $cour) {
                    try {
                        $this->getCoursService()->getEntityManager()->persist($cour);
                    } catch (ORMException $e) {
                        throw new RuntimeException($e->getMessage());
                    }
                }
                $this->getCoursService()->getEntityManager()->flush();
                $nAdded += count($cours);
                error_log('Cours added : ' . $nAdded . '/' . $nbCours);
            }
        }
        $result = [
            'success' => count($success),
            'failed' => count($failed),
            'failedMsg' => $failed[0] ?? '',
            'duplicate' => count($duplicate),
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

    public function getCourFromLine($line): ?Cours
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
            return null;
        }
        // check if cours already exists
        $cours = $this->getCoursService()->findOneBy(['codeElp' => $code]);
        $formation = $this->getFormationService()->findOneBy(['code' => $formationCode]);
        if (!$cours) {
            $cours = new Cours();
            $cours->setCodeElp($code);
            $cours->setHistoCreation(new DateTime());
            $cours->setHistoCreateur($this->getUserService()->getConnectedUser());
        }else {
            $cours->setHistoModification(new DateTime());
            $cours->setHistoModificateur($this->getUserService()->getConnectedUser());
        }
        if (!$formation) {
            return null;
        }

        $s1 = ($s1 == 1) ? '1' : '';
        $s2 = ($s2 == 1) ? '1' : '';
        $ouvertMobilite = $ouvertMobilite == 'true';
        $cours->setLibelle($libelle);
        $cours->setLangueEnseignement($langueEnseignement);
        $cours->setS1($s1);
        $cours->setS2($s2);
        $cours->setEcts($ects);
        $volElp = is_numeric($volElp) ? $volElp : null;
        $cours->setVolElp($volElp);
        $cours->setOuvertMobilite($ouvertMobilite);
        $cours->setFormation($formation);
        $cours->setObjectif($objectif);
        $cours->setDescription($description);
        $cours->setSource($this->getCsvSource());
        $cours->setSourceCode($code);

        return $cours;
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
        // check if cours already exists
        $cours = $this->getCoursService()->findOneBy(['codeElp' => $code]);
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
        $volElp = is_numeric($volElp) ? $volElp : null;
        $cours->setVolElp($volElp);
        $cours->setOuvertMobilite($ouvertMobilite);
        $cours->setFormation($formation);
        $cours->setObjectif($objectif);
        $cours->setDescription($description);
        try {
            $this->getCoursService()->add($cours);
            return ['success', $line];
        } catch (\Exception $e) {
            $line['errorMsg'] = $e->getMessage();
//            throw new RuntimeException($e->getMessage());
            return ['failed', $line];
        }
    }

    public function addFormationFromLine($line): array
    {
        $code = $line[0];
        $libelle = $line[1];
        $acronyme = $line[2];
        $acronymeTypeDiplome = $line[3];
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
        $typeDiplome = $this->getTypeDiplomeService()->findOneBy(['code' => $acronymeTypeDiplome]);
        if($typeDiplome) {
            $formation->setTypeDiplome($typeDiplome);
        }
        $formation->setNiveauEtude($niveauEtude);
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
     * @throws \Doctrine\DBAL\Exception
     */
    public function importODF(): array
    {
        $importLog = $this->createImportLog('API');

        $this->dropImportTables();
        $importLog['log'] = $importLog['log'] . 'Tables temporaires vidées.\n';
        $this->updateImportLog($importLog);

        // get data from smile-connect
        $composantes = $this->get('composantes');
        $importLog['log'] = $importLog['log'] . 'Get composantes.\n';
        $this->updateImportLog($importLog);
        $formations = $this->get('formations');
        $importLog['log'] = $importLog['log'] . 'Get formations.\n';
        $this->updateImportLog($importLog);
        $cours = $this->get('cours');
        $importLog['log'] = $importLog['log'] . 'Get cours.\n';
        $this->updateImportLog($importLog);

        if(!$composantes['success']) {
            $importLog['log'] = $importLog['log'] . 'Failed composantes.\n';
            $importLog['log'] = $importLog['log'] . $composantes['message'] . '\n';
            $importLog['success'] = 0;
            $importLog['ended_on'] = date('Y-m-d H:i:s');
            $this->updateImportLog($importLog);
            return [
                'success' => false,
                'message' => $composantes['message']
            ];
        }
        if(!$formations['success']) {
            $importLog['log'] = $importLog['log'] . 'Failed formations.\n';
            $importLog['log'] = $importLog['log'] . $formations['message'] . '\n';
            $importLog['success'] = 0;
            $importLog['ended_on'] = date('Y-m-d H:i:s');
            $this->updateImportLog($importLog);
            return [
                'success' => false,
                'message' => $formations['message']
            ];
        }
        if(!$cours['success']) {
            $importLog['log'] = $importLog['log'] . 'Failed cours.\n';
            $importLog['log'] = $importLog['log'] . $cours['message'] . '\n';
            $importLog['success'] = 0;
            $importLog['ended_on'] = date('Y-m-d H:i:s');
            $this->updateImportLog($importLog);
            return [
                'success' => false,
                'message' => $cours['message']
            ];
        }
        $importLog['log'] = $importLog['log'] . 'Inserting in temporary Database\n';
        $importLog['log'] = $importLog['log'] . 'Composante\n';
        $this->insertDataSql($composantes['data'], 'import_composante', Composante::class);
        $importLog['log'] = $importLog['log'] . 'Formation\n';
        $this->insertDataSql($formations['data'], 'import_formation', Formation::class);
        $importLog['log'] = $importLog['log'] . 'Cours\n';
        $this->insertDataSql($cours['data'], 'import_cours', Cours::class);
        $importLog['log'] = $importLog['log'] . 'End inserting\n\n';
        $this->updateImportLog($importLog);

        $importLog['log'] = $importLog['log'] . 'Synchronising with prod Database\n';
        $importLog = $this->getMySynchroService()->synchronise('COMPOSANTES', $importLog);
        $this->fillForeignKeys('import_formation');
        $importLog = $this->getMySynchroService()->synchronise('FORMATIONS', $importLog);
        $this->fillForeignKeys('import_cours');
        $importLog = $this->getMySynchroService()->synchronise('COURS', $importLog);

        $importLog['log'] = $importLog['log'] . 'End synchronising\n\n';
        $importLog['success'] = 1;
        $importLog['ended_on'] = date('Y-m-d H:i:s');
        $this->updateImportLog($importLog);
        return [
            'success' => true,
            'logs' => $importLog
        ];
    }

    protected function fillForeignKeys(string $entity): void
    {
        $connection = $this->getEntityManager()->getConnection();

        try {
            if($entity == 'import_formation') {
                $query = $connection->prepare('SELECT * FROM import_formation')->executeQuery();
                $formations = $query->fetchAllAssociative();
                foreach ($formations as $row) {
                    $code = $row['code'];
                    $composante = $row['cod_cmp'];
                    $typeFormation = $row['type_formation'];
                    $langueEnseignement = $row['langue_enseignement'] ?? 'Français';
                    $composante = $this->getEntityManager()->getRepository(Composante::class)->findOneBy(['code' => $composante]);
                    $typeDiplome = $this->getEntityManager()->getRepository(TypeDiplome::class)->findOneBy(['code' => $typeFormation]);
                    $langueEnseignement = $this->getEntityManager()->getRepository(Langue::class)->findOneBy(['libelle' => $langueEnseignement]);
                    $connection->executeQuery("UPDATE import_formation 
                        SET composante_id = '" . $composante->getId() . "', 
                        type_diplome_id = '" . $typeDiplome->getId() . "', 
                        langue_enseignement_id = '" . $langueEnseignement->getId() . "'
                        WHERE code = '$code'");
                }
            }elseif ($entity == 'import_cours') {
                $query = $connection->prepare('SELECT * FROM import_cours')
                    ->executeQuery();
                $cours = $query->fetchAllAssociative();
                foreach ($cours as $row) {
                    $code = $row['code_elp'];
                    $formation = $row['code_formation'];
                    $formation = $this->getEntityManager()->getRepository(
                        Formation::class
                    )->findOneBy(['code' => $formation]);
                    $connection->executeQuery(
                        "UPDATE import_cours SET formation_id = '"
                        . $formation->getId() . "' WHERE code_elp = '$code'"
                    );
                }
            }
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }

    }

    protected function insertDataSql(array $data, string $table, string $class): void
    {
        try {
            // Insert all data in the database using sql
            $connection = $this->getEntityManager()->getConnection();
            $connection->beginTransaction();

            $associations = $this->config['association'][$class];
            $columns = array_values($associations);

            $batchSize = 20;
            $values = [];
            foreach ($data as $i => $row) {
                $map = array_map(fn($key) => $this->echapValue($row[$key] ?? null), array_keys($associations));
                $values[] = '(' . implode(', ', $map) . ')';

                // If we've reached the batch size or the end of the data array, execute the query
                if (($i + 1) % $batchSize === 0 || $i === count($data) - 1) {
                    $sql = "INSERT INTO $table (" . implode(', ', array_values($associations)) . ") VALUES " . implode(', ', $values);
                    $connection->executeQuery($sql);
                    $values = []; // Reset the values array for the next batch
                }
            }
            $connection->commit();
        } catch (Exception $e) {
            $connection->rollBack();
            throw new RuntimeException($e->getMessage());
        }
    }

    public function dropImportTables(): void
    {
        try {
            $connection = $this->getEntityManager()->getConnection();
            $connection->executeQuery('DELETE FROM import_composante');
            $connection->executeQuery('DELETE FROM import_formation');
            $connection->executeQuery('DELETE FROM import_cours');
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    protected function echapValue(?string $value): string
    {
        if ($value === null or $value === '') return "null";
        if($value === 'S1' || $value === 'S2') {
            $value = 1;
        }
        return "'" . str_replace("'", "''", $value) . "'";
    }

    protected function updateData(array $data, string $class): void
    {
        $created = 0;
        $updated = 0;
        $removed = 0;

        foreach ($data as $entity) {
            $entity = $this->getEntity($entity, $class);
            $existingEntity = $this->getEntityManager()->getRepository($class)->findOneBy(['code' => $entity->getCode()]);
            if ($existingEntity) {
//                $this->getEntityManager()->merge($entity);
                $updated++;
            } else {
//                $this->getEntityManager()->persist($entity);
                $created++;
            }
        }
    }

    public function getEntity(array $data, string $class): object
    {
        $entity = new $class();
        foreach ($data as $key => $value) {
            // if key start with '@' go to next value
            if (str_starts_with($key, '@')) {
                continue;
            }
            $setter = 'set' . ucfirst($this->findKeyAssociated($key, $class));
            if (method_exists($entity, $setter)) {
                $entity->$setter($value);
            }
        }
        return $entity;
    }

    public function findKeyAssociated(string $key, string $class): string
    {
        $association = $this->config['association'][$class];
        return $association[$key] ?? $key;
    }

    public function get(string $entities): array
    {
        try {
            $res = $this->parseLdJson($entities);
        } catch (GuzzleException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
        return [
            'success' => true,
            'data' => $res
        ];
    }

    /**
     * @throws GuzzleException
     */
    public function parseLdJson(string $entities): array
    {
        $client = new Client();
        $allData = [];
        $url = $entities;
        do {
            $response = $client->request('GET', $this->buildUrl($_ENV['SMILE_CONNECT_URL'], $url), [
                'auth' => [$_ENV['SMILE_CONNECT_USER'], $_ENV['SMILE_CONNECT_PASSWORD']],
                'headers' => [
                    'Accept' => 'application/ld+json'
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            // Add the current page's data to the allData array
            $allData = array_merge($allData, $data['hydra:member']);

            // Check if there is a next page
            $url = $data['hydra:view']['hydra:next'] ?? null;

        } while ($url !== null); // Continue if there is a next page

        return $allData;
    }

    public function buildUrl(string $host, string $uri): string
    {
        return rtrim($host, '/') . '/' . ltrim($uri, '/');
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    protected function createImportLog(string $type): array
    {
        $createdDate = new DateTime();
        $timestamp = $createdDate->getTimestamp();
        $pgTimestamp = date('Y-m-d H:i:s', $timestamp);

        $importLog = [
            'code' => Uuid::uuid4(),
            'type' => $type,
            'name' => 'ImportODF',
            'log' => null,
            'success' => 0,
            'started_on' => $pgTimestamp,
            'ended_on' => null
        ];

        $connection = $this->getEntityManager()->getConnection();
        $connection->insert('import_log', [
            'code' => $importLog['code'],
            'type' => $importLog['type'],
            'name' => $importLog['name'],
            'success' => $importLog['success'],
            'started_on' => $importLog['started_on']
        ]);

        return $importLog;
    }

    protected function updateImportLog(array $importLog): void
    {
        $connection = $this->getEntityManager()->getConnection();
        $connection->update('import_log', [
            'success' => $importLog['success'],
            'log' => $importLog['log'],
            'ended_on' => ($importLog['ended_on']) ? $importLog['ended_on'] : null
        ], [
            'code' => $importLog['code']
        ]);
    }

    public function getImportLogs(): array
    {
        $em = $this->getEntityManager();
        $logs = $em->getRepository('Application\Entity\ImportLog')->findBy([], ['startedOn' => 'DESC'], 10);
        return $logs;
    }

}