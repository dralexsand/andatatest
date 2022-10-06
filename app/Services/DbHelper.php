<?php


namespace App\Services;

use App\Core\DB;
use App\Databases\Migration;
use PDO;

class DbHelper
{
    protected readonly PDO $connection;

    public function __construct()
    {
        $db = DB::getInstance();
        $this->connection = $db->getConnection();
    }

    public static function getConnect(): PDO
    {
        $dbHelper = new DbHelper();
        return $dbHelper->connection;
    }

    public static function buildSqlPhrase($table, $rowDataArray): string
    {
        $types = self::getTableByName($table);
        $valueListArray = [];

        foreach ($rowDataArray as $field => $value) {
            $valueListArray[] = self::convertSqlValue($value, $types[$field]);
        }

        return "(" . implode(',', $valueListArray) . ")";
    }

    public static function convertSqlValue(string $sqlValue, string $type): string
    {
        return strtolower($type) === 'int' ? $sqlValue : "'$sqlValue'";
    }

    public static function buildMultiInsertSql(array $dataTable): string
    {
        $table = $dataTable['table'];

        $columnListArray = array_keys($dataTable['data'][0]);
        $columnList = implode(',', $columnListArray);
        $sql = "INSERT INTO {$table} ($columnList) ";
        $valuesRow = [];

        foreach ($dataTable['data'] as $rowDataArray) {
            $valuesRow[] = self::buildSqlPhrase($table, $rowDataArray);
        }

        $values = implode(',', $valuesRow) . ";";
        $sql .= " VALUES {$values}";

        return $sql;
    }

    public static function buildInsertSql(array $dataTable): string
    {
        $table = $dataTable['table'];

        $columnListArray = array_keys($dataTable['data']);
        $columnList = implode(',', $columnListArray);
        $sql = "INSERT INTO {$table} ($columnList) ";
        $valuesRow = [];

        $rowDataArray = $dataTable['data'];
        $values = self::buildSqlPhrase($table, $rowDataArray);
        $sql .= " VALUES {$values}";

        return $sql;
    }

    public static function executeQuery(string $sql)
    {
        $stmt = self::getConnect()->query($sql);
        $rows = [];

        while ($row = $stmt->fetch()) {
            $rows[] = $row;
        }

        return $rows;
    }

    public static function dropTable(string $tableName)
    {
        $sql = "DROP TABLE IF EXISTS {$tableName}";
        self::executeQuery($sql);
    }

    public static function buildSqlCreateTable(array $dataTable): string
    {
        $sql = "CREATE TABLE {$dataTable['table']} (";

        foreach ($dataTable['fields'] as $fieldName => $fieldDescription) {
            $sql .= "{$fieldName} {$fieldDescription},";
        }

        $sql .= "PRIMARY KEY ({$dataTable['primary']})";
        $sql .= ");";
        return $sql;
    }

    /**
     * @param string $tableName
     * @return array
     */
    public static function getTableByName(string $tableName): array
    {
        $fieldsTable = [];
        foreach (Migration::getTables() as $table) {
            if ($table['table'] === $tableName) {
                $fieldsTableDefinitions = $table['fields'];
                $fieldsTable = self::getFieldTypes($fieldsTableDefinitions);
                break;
            }
        }

        return $fieldsTable;
    }

    /**
     * @param array $fieldsTableDefinitions
     * @return array
     */
    public static function getFieldTypes(array $fieldsTableDefinitions): array
    {
        $fieldsTypes = [];
        foreach ($fieldsTableDefinitions as $field => $fieldDefinition) {
            $fieldsTypes[$field] = self::getFieldType($fieldDefinition);
        }
        return $fieldsTypes;
    }

    /**
     * @param string $fieldDefinition
     * @return string
     */
    public static function getFieldType(string $fieldDefinition): string
    {
        $definition = explode(' ', $fieldDefinition);
        return $definition[0];
    }
}