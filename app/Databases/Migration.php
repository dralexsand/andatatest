<?php


namespace App\Databases;

class Migration
{

    /**
     * @return array[]
     */
    public static function getTables(): array
    {
        return [
            [
                'table' => 'users',
                'fields' => [
                    'id' => 'INT NOT NULL AUTO_INCREMENT',
                    'username' => 'VARCHAR(45) NOT NULL',
                    'email' => 'VARCHAR(45) NOT NULL',
                ],
                'primary' => 'id'
            ],
            [
                'table' => 'comments',
                'fields' => [
                    'id' => 'INT NOT NULL AUTO_INCREMENT',
                    'user_id' => 'BIGINT NOT NULL',
                    'comment' => 'TEXT NOT NULL',
                    'created_at' => 'DATETIME NOT NULL',
                ],
                'primary' => 'id'
            ],
        ];
    }
}
