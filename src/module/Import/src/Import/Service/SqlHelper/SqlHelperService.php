<?php

namespace Import\Service\SqlHelper;

use Doctrine\DBAL\Driver\Exception as DRV_Exception;
use Doctrine\DBAL\Exception as DBA_Exception;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Persistence\ProvidesObjectManager;
use RuntimeException;

class SqlHelperService
{
    use ProvidesObjectManager;

    public function executeRequeteRef(EntityManager $entityManager, string $sql, array $params): array
    {
        try {
            $res = $entityManager->getConnection()->executeQuery($sql, $params);
            try {
                $tmp = $res->fetchAllAssociative();
            } catch (DRV_Exception $e) {
                echo "033[31mUn problème est survenu lors de l'utilisation du drivers\033[0m";
                throw new RuntimeException("Un problème est survenu [DRV_Exception]", 0, $e);
            }
        } catch (DBA_Exception $e) {
            echo "033[31mUn problème est survenu lors de l'utilisation de la base de donnée\033[0m";
            throw new RuntimeException("Un problème est survenu [DBA_Exception]", 0, $e);
        }

        return $tmp;
    }



    public function fetch(EntityManager $entityManager, string $table, array $correspondance, string $type, string $id, string $separatorColumn = null, string $separatorValue = null): array
    {
        $columns = [];
        foreach ($correspondance as $s => $d) {
            if ($type === 'source') $columns[] = $s;
            if ($type === 'destination') $columns[] = $d;
        }
        if ($type === 'destination') $columns[] = 'deleted_on';
        if ($type === 'destination') $columns[] = 'source_id';

        $sql    = "select " . implode(" , ", $columns) . " from " . $table;
        if($separatorColumn !== null && $separatorValue !== ''){
            $sql .= " where " . $separatorColumn . " = '" . $separatorValue . "'";
        }
        $data   = $this->executeRequeteRef($entityManager, $sql, []);
        $values = [];

        foreach ($data as $item) {
            $values[$item[$id]] = $item;
        }

        return $values;
    }



    public function fetchValuesSeparator(EntityManager $entityManager, string $table, string $column): array
    {


        $sql    = "select " . $column . " from " . $table . " group by " . $column . ' order by '.$column;
        $values = $this->executeRequeteRef($entityManager, $sql, []);

        return $values;
    }



    //todo que ce passe t'il pour les booleans
    public function echapValue(?string $value): string
    {
        if ($value === null or $value === '') return "null";

        return "'" . str_replace("'", "''", $value) . "'";
    }



    public function insert(EntityManager $entityManager, string $table, array $item, array $correspondance, ?string $source = null): void
    {
        $columns = [];
        foreach ($correspondance as $d) {
            $columns[] = $d;
        }
        $columns[] = "created_on";
        if ($source !== null) $columns[] = 'source_id';
        $values = [];
        foreach ($correspondance as $s => $d) {
            $values[] = $this->echapValue($item[$s]);
        }
        $values[] = "now()";
        if ($source !== null) $values[] = "'" . $source . "'";
        $sql = "insert into " . $table . " (" . implode(',', $columns) . ") values (" . implode(',', $values) . ")";
        $this->executeRequeteRef($entityManager, $sql, []);
    }



    public function update(EntityManager $entityManager, string $table, array $item, array $correspondance, string $id, string $columnId, ?string $source = null): void
    {
        $values = [];
        foreach ($correspondance as $s => $d) {
            $values[] = $d . "=" . $this->echapValue($item[$s]);
        }
        if ($source !== null) $values[] = "source_id='" . $source . "'";
        $values[] = "updated_on=now()";
        $sql      = "update " . $table . " set " . implode(" , ", $values) . " where " . $columnId . "=:id";
//        echo $sql.' :id='.$id.' \n';
        $this->executeRequeteRef($entityManager, $sql, ["id" => $id]);
    }



    public function restore(EntityManager $entityManager, string $table, string $id, string $columnId): void
    {
        $sql = "update " . $table . " set deleted_on=NULL where " . $columnId . "=:id";
        $this->executeRequeteRef($entityManager, $sql, ["id" => $id]);
    }



    public function delete(EntityManager $entityManager, string $table, string $id, string $columnId): void
    {
        $sql = "update " . $table . " set deleted_on=now() where " . $columnId . "=:id";
        $this->executeRequeteRef($entityManager, $sql, ["id" => $id]);
    }
}