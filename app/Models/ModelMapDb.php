<?php


namespace App\Models;

use App\Services\DbHelper;

class ModelMapDb
{
    protected string $table;
    protected array $definedFields;

    public function getEntityIdByDefinedFields(array $request)
    {
        if (empty($this->getDefinedFields())) {
            return "Error: defined fields array is empty";
        }

        $table = $request['table'];
        $data = $request['data'];
        $types = DbHelper::getTableByName($table);

        $whereArray = [];

        foreach ($this->getDefinedFields() as $field) {
            $value = DbHelper::convertSqlValue($data[$field], $types[$field]);
            $whereArray[] = " $field IN ({$value})";
        }

        $where = " WHERE " . $whereArray[0];

        unset($whereArray[0]);

        if (!empty($whereArray)) {
            foreach ($whereArray as $key => $whereItem) {
                $where .= " AND {$whereItem}";
            }
        }

        $sql = "
            SELECT id 
            FROM {$this->table}
            {$where};
        ";

        $entity = DbHelper::executeQuery($sql);
        $entityId = $entity[0]['id'] ?? null;

        if (!$entityId) {
            $sql = DbHelper::buildInsertSql($request);
            $entity = DbHelper::executeQuery($sql);
            $sql = "SELECT LAST_INSERT_ID()";
            $entity = DbHelper::executeQuery($sql);
            $entityId = $entity[0]['LAST_INSERT_ID()'];
        }

        return $entityId;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @param string $table
     */
    public function setTable(string $table): void
    {
        $this->table = $table;
    }

    /**
     * @return array
     */
    public function getDefinedFields(): array
    {
        return $this->definedFields;
    }

    /**
     * @param array $definedFields
     */
    public function setDefinedFields(array $definedFields): void
    {
        $this->definedFields = $definedFields;
    }

    public function getById(int $id)
    {
        $sql = "
            SELECT * 
            FROM {$this->table}
            WHERE id IN ({$id});
        ";

        return DbHelper::executeQuery($sql);
    }

    public function findOrCreateEntity(array $request): int
    {
        return $this->getEntityIdByDefinedFields($request);
    }

    public function createEntity(array $request): int
    {
        $sql = DbHelper::buildInsertSql($request);
        $entity = DbHelper::executeQuery($sql);
        $sql = "SELECT LAST_INSERT_ID()";
        $entity = DbHelper::executeQuery($sql);
        return $entity[0]['LAST_INSERT_ID()'];
    }
}