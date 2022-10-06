<?php


namespace App\Core;

use PDO;
use PDOException;

class DB
{
    private PDO $connection;
    private static $_instance;

    private string $dbhost;
    private string $dbuser;
    private string $dbpass;
    private string $dbname;

    public function __construct()
    {
        $config = Config::getEnv();

        $this->dbhost = $config['DB_HOST'];
        $this->dbname = $config['DB_DATABASE'];
        $this->dbuser = $config['DB_USERNAME'];
        $this->dbpass = $config['DB_PASSWORD'];

        try {
            $this->connection = new PDO(
                'mysql:host=' . $this->dbhost . ';dbname=' . $this->dbname,
                $this->dbuser,
                $this->dbpass
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->connection->query('set names utf8');
            // Error handling
        } catch (PDOException $e) {
            die("Failed to connect to DB: " . $e->getMessage());
        }
    }

    /*
     Get an instance of the Database
     @return Instance
     */
    public static function getInstance(): DB
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    // Magic method clone is empty to prevent duplication of connection
    private function __clone()
    {
    }

    // Get the connection
    public function getConnection(): PDO
    {
        return $this->connection;
    }
}