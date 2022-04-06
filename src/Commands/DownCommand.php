<?php

namespace SimpleMigration\Commands;

use SimpleMigration\Database\Connection;
use SimpleMigration\Migrator;

class DownCommand
{

    public function handle()
    {
        $migration = new Migrator(new Connection());
        $migration->downMigrations();
    }
}