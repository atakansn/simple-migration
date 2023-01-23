<?php

namespace SimpleMigration\Commands;

use SimpleMigration\Database\Connection;
use SimpleMigration\Migrator;

class DownCommand
{
    public function handle()
    {
        $database = require __DIR__ . '/../../Database/database.php';
        $migration = new Migrator(new Connection($database));
        $migration->downMigrations();
    }
}
