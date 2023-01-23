<?php

namespace SimpleMigration\Database;

use Dotenv\Dotenv;

class Connection
{
    private \PDO $pdo;

    public function __construct(array $values)
    {
        [$user, $password] = [
            $values['user'] ?? null,
            $values['password'] ?? null
        ];

        $dsn = "mysql:host={$values['host']};dbname={$values['database']}";

        if (array_key_exists('port', $values)) {
            $dsn = "mysql:host={$values['host']};port={$values['port']};dbname={$values['database']}";
        }

        try {
            $this->createPdoConnection($dsn, $user, $password);

        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    private function createPdoConnection($dsn, $username, $password)
    {
        $this->pdo = new \PDO($dsn, $username, $password);
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}
