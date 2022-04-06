<?php

namespace SimpleMigration;

use Dotenv\Dotenv;
use SimpleMigration\Database\Connection;

class Application
{
    public Migrator $migrator;

    public Console $console;

    public function __construct(Connection $connection, array $args = [])
    {

        $this->migrator = new Migrator($connection);

        $this->console = new Console($args,$this->migrator);

    }

    public function run()
    {
        $this->console->start();
    }





}