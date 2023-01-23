<?php

namespace SimpleMigration;


use SimpleMigration\Helpers\ConsoleOutput;
use SimpleMigration\Helpers\FileSystem;

class MigrationCreator
{
    private const STUB_PATH = __DIR__ . '/Stubs';

    private object $fileSystem;

    public string $migrationPath;

    public function __construct(FileSystem $file, string $path)
    {
        $this->fileSystem = $file;
        $this->migrationPath = $path;
    }

    public function create(string $name, string $path = null)
    {
        $fileName = $this->getPathWithFilename($name, $path);

        $this->fileSystem->directoryExists($path);

        $this->migrationExist($name, $fileName);

        $this->populateStub($this->getStub(), $fileName, $name, $fileName);

    }

    public function getStub()
    {
        $this->fileSystem->exists($stub = self::STUB_PATH . '/migration.stub');
        return $this->fileSystem->get($stub);
    }

    private function getDatePrefix()
    {
        return date("Y_m_d");
    }

    private function getPathWithFilename(string $name, string $path)
    {
        return $path . '/' . $name . '_' . $this->getDatePrefix() . '.php';
    }

    private function populateStub(string $stubs, ?string $path, string $table, string $className)
    {
        $stubs = str_replace(
            ['$name', '$tableName'],
            [$this->fileSystem->basename($className, '.php'), $table],
            $stubs);
        $this->fileSystem->put($path, $stubs);
        echo (new ConsoleOutput())->applyStyle(['light_green'], "Migration Created : " . basename($className));
    }

    private function migrationExist(string $name, string $file)
    {
        if (empty($name)) {
            echo (new ConsoleOutput())->applyStyle(['light_yellow'], "Warning : Please specify the file name.");
            die;
        }

        $className = basename($file, '.php');

        if (file_exists($file)) {
            echo (new ConsoleOutput())->applyStyle(['red'], "A {$className} class already exists.");
            die;
        }

    }


}
