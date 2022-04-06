<?php

namespace SimpleMigration;

use SimpleMigration\Database\Connection;
use SimpleMigration\Helpers\ConsoleOutput;

class Migrator
{

    public $db;

    public function __construct(Connection $connection = null)
    {
        $this->db = $connection;
    }

    public function applyMigrations()
    {
        $this->createMigrationTable();
        $appliedMigrations = $this->getAppliedMigraitons();

        $newMigrations = [];
        $files = scandir(__DIR__ . '/../Database/Migrations/');
        $toApplyMigrations = array_diff($files, $appliedMigrations);

        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }

            require dirname(__DIR__) . '/Database/Migrations/' . $migration;
            $classname = pathinfo($migration, PATHINFO_FILENAME);
            $fullClassName = sprintf('%s\\%s', 'SimpleMigration\\Database\\Migrations', $classname);

            (new $fullClassName())->up();

            echo ConsoleOutput::getInstance()->applyStyle(['light_cyan'], "Applied migration : {$migration}") . PHP_EOL;

            $newMigrations[] = $migration;
        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        }

        echo ConsoleOutput::getInstance()->applyStyle(['light_green', 'bold'], "All migrations applied.");

    }

    final public function createMigrationTable()
    {
        $this->db->getPdo()->exec("
                    CREATE TABLE IF NOT EXISTS
            migrations
        (
            id         INT AUTO_INCREMENT PRIMARY KEY,
            migration  VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE = INNODB;
        ");
    }

    public function saveMigrations(array $migrations)
    {
        foreach ($migrations as $migration) {
            $stmt = $this->db->getPdo()->prepare("INSERT INTO migrations SET migration=:migration");
            $stmt->execute(['migration' => $migration]);
        }
    }

    public function getAppliedMigraitons()
    {
        return $this->db->getPdo()->query("SELECT migration FROM migrations")->fetchAll(\PDO::FETCH_COLUMN);
    }

    private function migrationsCount()
    {
        $c = $this->db->getPdo()->query("SELECT migration FROM migrations");
        $c->execute();
        return $c->rowCount();
    }

    public function downMigrations()
    {
        if($this->migrationsCount() === 0)
        {
            echo ConsoleOutput::getInstance()->applyStyle(['light_yellow'],'Migrations have already been removed');
        }

        foreach (glob(__DIR__ . '/../Database/Migrations/*.php') as $migrations) {
            $basename = basename($migrations, '.php');
            $className = sprintf('%s\\%s', $this->findNamespace($migrations), $basename);
            $migration = new $className();
            $migration->down();
            echo ConsoleOutput::getInstance()->applyStyle(['light_magenta'], "Removed migration : {$basename}") . PHP_EOL;
        }

    }

    public function findNamespace($name)
    {
        $preg = preg_grep('/^namespace/', file($name));
        $trim = trim(array_shift($preg));
        preg_match('/^namespace (.*);$/', $trim, $match);
        return array_pop($match);
    }


}