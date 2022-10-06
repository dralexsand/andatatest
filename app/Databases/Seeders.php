<?php

declare(strict_types=1);


namespace App\Databases;

class Seeders
{
    /**
     * @return array
     */
    public static function seedUsers(): array
    {
        return [
            'table' => 'users',
            'data' => [
                [
                    'username' => 'bred',
                    'email' => 'bred@mail.com',
                ],
                [
                    'username' => 'leo',
                    'email' => 'leo@mail.com',
                ],
                [
                    'username' => 'mickey',
                    'email' => 'mickey@mail.com',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public static function seedComments(): array
    {
        return [
            'table' => 'comments',
            'data' => [
                [
                    'user_id' => 1,
                    'comment' => 'Bred comment #1',
                    'created_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'user_id' => 2,
                    'comment' => 'Leo comment #1',
                    'created_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'user_id' => 3,
                    'comment' => 'Mickey  comment #1',
                    'created_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'user_id' => 1,
                    'comment' => 'Bred comment #2',
                    'created_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'user_id' => 2,
                    'comment' => 'Leo comment #2',
                    'created_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'user_id' => 1,
                    'comment' => 'Bred comment #3',
                    'created_at' => date('Y-m-d H:i:s'),
                ],
            ]
        ];
    }
}