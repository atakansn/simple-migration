<?php

namespace SimpleMigration;

use SimpleMigration\Database\Connection;
use SimpleMigration\Helpers\ConsoleOutput;

abstract class Migration
{
    public $db;

    abstract public function up();

    abstract public function down();

    public function __construct()
    {
        $this->db = new Connection();
    }

    public function getConnection()
    {
        return $this->db->getPdo();
    }

    public function create(string $tableName, array $columns)
    {
        $column = implode(', ', $columns);
        $sql = "CREATE TABLE {$tableName} ({$column})";
        try {
            $this->getConnection()->exec($sql);
        } catch (\Exception $exception) {
            echo ConsoleOutput::getInstance()->applyStyle('red',$exception->getMessage()).PHP_EOL;
            exit;
        }
    }

    public function drop(string $tableName)
    {
        try {
            $this->getConnection()->exec("TRUNCATE migrations");
            return $this->getConnection()->exec("DROP TABLE {$tableName}");
        } catch (\Exception $e) {
            (new ConsoleOutput())->applyStyle(['red'], $e->getMessage()).PHP_EOL;
            exit;
        }
    }


    public function id(string $column = "id", int $length = 11)
    {
        return "$column BIGINT($length) AUTO_INCREMENT PRIMARY KEY";
    }

    public function string(string $column, int $length = 255)
    {
        return "$column VARCHAR($length)";
    }

    public function int(string $column, int $length = 11)
    {
        return "$column INT($length)";
    }

    public function timestamp()
    {
        return "created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
    }

}