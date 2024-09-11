<?php

namespace Import\Service\MySynchro;

use DateTime;
use Exception;
use Import\Service\SqlHelper\SqlHelperServiceAwareTrait;

class MySynchroService
{
    use SqlHelperServiceAwareTrait;

    private array $entityManagers = [];

    public function setEntityManagers(array $entityManagers): void
    {
        $this->entityManagers = $entityManagers;
    }



    private array $configs = [];



    public function setConfigs(array $configs): void
    {
        $this->configs = $configs;
    }



    public function getFromConfig(string $name, string $key)
    {
        if(isset($this->configs[$name][$key])) {
            return $this->configs[$name][$key];
        }
        return null;
    }



    private function checkDifferences(array $itemSource, array $itemDestination, array $correspondance, ?string $source = null): bool
    {
        foreach ($correspondance as $idSource => $idCorrespondance) {
            if ($itemSource[$idSource] != $itemDestination[$idCorrespondance]) {
//                var_dump($itemSource[$idSource]);
//                var_dump($itemDestination[$idCorrespondance]);
//                var_dump("Diff: " . $idSource . " >>> " . $itemSource[$idSource] . "!=" . $itemDestination[$idCorrespondance]);
//                die();
                return true;
            }
        }
        if ($source !== null) {
//            var_dump($source);
//            var_dump($itemDestination);
//            die();
//            var_dump($itemDestination['source_id']);
//            die();
            if ($itemDestination['source_id'] !== $source) return true;
        }

        return false;
    }



    public function synchronise(string $name, array $importLog): array
    {
        try {
            echo "Synchronisation [" . $name . "]\n";
            $importLog['log'] = $importLog['log'] . "Synchronisation [" . $name . "]\n";
            flush();
            $debut = new DateTime();
            echo "Debut: " . $debut->format('d/m/y H:i:s:u') . "\n";
            $importLog['log'] = $importLog['log'] . "Debut: " . $debut->format('d/m/y H:i:s:u') . "\n";
            flush();

            $correspondance    = $this->getFromConfig($name, 'correspondance');
            $orm_source        = $this->entityManagers[$this->getFromConfig($name, 'orm_source')];
            $orm_destination   = $this->entityManagers[$this->getFromConfig($name, 'orm_destination')];
            $table_source      = $this->getFromConfig($name, 'table_source');
            $table_destination = $this->getFromConfig($name, 'table_destination');
            $id_source         = $this->getFromConfig($name, 'id');
            $source            = $this->getFromConfig($name, 'source');
            $id_destination    = $correspondance[$id_source];
            $separatorSource   = $this->getFromConfig($name, 'separator');

            if ($separatorSource != null && $separatorSource != "") {
                $separatorValuesSource      = $this->getSqlHelperService()->fetchValuesSeparator($orm_source, $table_source, $separatorSource);
                $separatorValuesDestination = $this->getSqlHelperService()->fetchValuesSeparator($orm_destination, $table_destination, $correspondance[$separatorSource]);

                $separatorValues = array_unique(array_merge(
                    array_map(function (array $a) use ($separatorSource) {
                        return $a[$separatorSource];
                    }, $separatorValuesSource),
                    array_map(function ($a) use ($correspondance, $separatorSource) {
                        return $a[$correspondance[$separatorSource]];
                    }, $separatorValuesDestination)
                ));
                sort($separatorValues);
                foreach ($separatorValues as $separatorValue) {
                    echo "Traitement " . $separatorValue . "\n";
                    $importLog['log'] = $importLog['log'] . "Traitement " . $separatorValue . "\n";
                    $data_source      = $this->getSqlHelperService()->fetch($orm_source, $table_source, $correspondance, 'source', $id_source, $separatorSource, $separatorValue);
                    $data_destination = $this->getSqlHelperService()->fetch($orm_destination, $table_destination, $correspondance, 'destination', $id_destination, $separatorSource, $separatorValue);
                    echo count($data_source) . " entrées dans les données sources.\n";
                    $importLog['log'] = $importLog['log'] . count($data_source) . " entrées dans les données sources.\n";
                    $importLog = $this->doSynchronisation($name, $data_source, $data_destination, $importLog);
                }
            } else {
                $data_source      = $this->getSqlHelperService()->fetch($orm_source, $table_source, $correspondance, 'source', $id_source);
                $data_destination = $this->getSqlHelperService()->fetch($orm_destination, $table_destination, $correspondance, 'destination', $id_destination);
                echo count($data_source) . " entrées dans les données sources.\n";
                $importLog['log'] = $importLog['log'] . count($data_source) . " entrées dans les données sources.\n";
                $importLog = $this->doSynchronisation($name, $data_source, $data_destination, $importLog);
            }

            flush();
        } catch (Exception $e) {
            do {
                echo "\033[31m" . $e->getMessage() . "\033[0m\n";
                $importLog['log'] = $importLog['log'] . "\033[31m" . $e->getMessage() . "\033[0m\n";
                $e = $e->getPrevious();
            } while ($e !== null);
            $importLog['success'] = false;
            $importLog['ended_on'] = new DateTime();
        }

        return $importLog;
    }



    private function doSynchronisation(string $name, array $data_source, array $data_destination, array $importLog): array
    {
        $correspondance    = $this->getFromConfig($name, 'correspondance');
        $orm_destination   = $this->entityManagers[$this->getFromConfig($name, 'orm_destination')];
        $table_destination = $this->getFromConfig($name, 'table_destination');
        $source            = $this->getFromConfig($name, 'source');
        $columnId          = $this->getFromConfig($name, 'id');

        $debut = new DateTime();

        $data_destination_on  = [];
        $data_destination_off = [];
        foreach ($data_destination as $item) {
            if ($item['deleted_on'] !== null) $data_destination_off[] = $item; else $data_destination_on[] = $item;
        }
        echo count($data_destination_on) . "(~" . count($data_destination_off) . ")" . " entrées dans les données cibles actives.\n";
        $importLog['log'] = $importLog['log'] . count($data_destination_on) . "(~" . count($data_destination_off) . ")" . " entrées dans les données cibles actives.\n";;
        flush();

        $read = new DateTime();
        echo "Lecture: " . $read->format('d/m/y H:i:s:u') . "(" . ($read->diff($debut))->format('%H:%m:%s:%F') . ")\n";
        $importLog['log'] = $importLog['log'] . "Lecture: " . $read->format('d/m/y H:i:s:u') . "(" . ($read->diff($debut))->format('%H:%m:%s:%F') . ")\n";
        flush();

        //check for removal
        $nbRetrait = 0;
        //        $texte_retrait = "";
        foreach ($data_destination as $id => $item) {
            if ($item['deleted_on'] === null and !isset($data_source[$id])) {
                $nbRetrait++;
                //                $texte_retrait .= "Retrait de ".$id." des données destination.\n";
                $this->getSqlHelperService()->delete($orm_destination, $table_destination, $id, $columnId);
            }
        }

        echo "#Retrait: " . $nbRetrait . "\n";
        $importLog['log'] = $importLog['log'] . "#Retrait: " . $nbRetrait . "\n";
        flush();
        //        $log .= $texte_retrait;

        //check for adding
        $nbAjout = 0;
        //        $texte_ajout = "";
        foreach ($data_source as $id => $item) {
            if (!isset($data_destination[$id])) {
                $nbAjout++;
                //                $texte_ajout .= "Ajout de ".$id." des données sources.\n";
                $this->getSqlHelperService()->insert($orm_destination, $table_destination, $item, $correspondance, $source);
            }
        }
        echo "#Ajout: " . $nbAjout . "\n";
        $importLog['log'] = $importLog['log'] . "#Ajout: " . $nbAjout . "\n";
        flush();
        //        $log .= $texte_ajout;

        //check for restauration
        $nbRestauration = 0;
        //        $texte_restauration = "";
        foreach ($data_source as $id => $item) {
            if (isset($data_destination[$id]) and $data_destination[$id]["deleted_on"] !== null) {
                $nbRestauration++;
                //                $texte_restauration .= "Restauration de ".$id." des données destinations.\n";
                $this->getSqlHelperService()->restore($orm_destination, $table_destination, $id, $columnId);
            }
        }
        echo "#Restauration: " . $nbRestauration . "\n";
        $importLog['log'] = $importLog['log'] . "#Restauration: " . $nbRestauration . "\n";
        flush();
        //        $log .= $texte_restauration;

        //check for modification
        $nbModification = 0;
        //        $texte_modication = "";
        foreach ($data_source as $id => $item) {
            if (isset($data_destination[$id]) and $this->checkDifferences($item, $data_destination[$id], $correspondance, $source)) {
                $nbModification++;
                //                $texte_modication .= "Modif de ".$id." des données sources.\n";
                $this->getSqlHelperService()->update($orm_destination, $table_destination, $item, $correspondance, $id, $columnId, $source);
            }
        }
        echo "#Modification: " . $nbModification . "\n";
        $importLog['log'] = $importLog['log'] . "#Modification: " . $nbModification . "\n";
        flush();
        //        $log .= $texte_modication;

        $fin = new DateTime();
        echo "Fin: " . $fin->format('d/m/y H:i:s:u') . "\n";
        $importLog['log'] = $importLog['log'] . "Fin: " . $fin->format('d/m/y H:i:s:u') . "\n";
        echo "Durée de la synchronisation: " . ($fin->diff($debut))->format('%H:%m:%s:%F') . "\n";
        $importLog['log'] = $importLog['log'] . "Durée de la synchronisation: " . ($fin->diff($debut))->format('%H:%m:%s:%F') . "\n";
        return $importLog;
    }

}