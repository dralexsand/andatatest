<?php


namespace App\Services;

use App\Databases\Seeders;

class SeederService
{

    public function run(): void
    {
        $this->seedDataTable(Seeders::seedUsers());
        $this->seedDataTable(Seeders::seedComments());
    }

    public function seedDataTable(array $dataTable): void
    {
        $sql = DbHelper::buildMultiInsertSql($dataTable);
        DbHelper::executeQuery($sql);
    }
}