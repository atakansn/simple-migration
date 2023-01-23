<?php

namespace SimpleMigration\Commands;

use SimpleMigration\Helpers\FileSystem;
use SimpleMigration\MigrationCreator;

class CreateCommand
{
    public const MIGRATION_PATH = __DIR__ . '/../../Database/Migrations';

    public string $fileName;

    public MigrationCreator $creator;


    public function __construct(array $args)
    {
        $this->fileName = $args[1] ?? "";

        $this->creator = new MigrationCreator(new FileSystem(), self::MIGRATION_PATH);
    }

    public function handle()
    {
        $this->creator->create($this->fileName, self::MIGRATION_PATH);
    }

}
