<?php

namespace SimpleMigration\Database;

use Dotenv\Dotenv;

class Connection
{
    private \PDO $Pdo;

    public function __construct()
    {
        try {
            $this->createPdoConnection($_ENV['DB_TYPE'].':host='.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_NAME'],$_ENV['DB_USER'],$_ENV['DB_PASSWORD']);

        }catch (\Exception $exception)
        {
            echo $exception->getMessage();
        }
    }

    private function createPdoConnection($dsn,$username,$password)
    {
        $this->Pdo = new \PDO($dsn,$username,$password);
    }

    public function getPdo()
    {
        return $this->Pdo;
    }

}