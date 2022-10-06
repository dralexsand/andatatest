<?php


namespace App\Services;

use App\Databases\Migration;

class MigrationService
{

    /**
     * @return void
     */
    public static function createMigrations(): void
    {
        $dataTables = Migration::getTables();

        foreach ($dataTables as $dataTable) {
            DbHelper::dropTable($dataTable['table']);
            $sql = DbHelper::buildSqlCreateTable($dataTable);
            DbHelper::executeQuery($sql);
        }
    }
}