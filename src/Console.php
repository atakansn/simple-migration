<?php

namespace SimpleMigration;

class Console
{

    private array $args = [];

    private array $commandFiles = [];

    private string $command;

    private Migrator $migrate;

    public function __construct(array $argv, Migrator $migrator)
    {
        $this->migrate = $migrator;

        $this->parseCommand($argv);
    }

    private function parseCommand(array $commands)
    {
        $this->setArgs(array_slice($commands,1));

        if(count($this->getArgs()) < 1)
        {
            $this->migrate->applyMigrations();
            exit;
        }

        $this->setCommand($this->getArgs()[0]);

    }

    public function start()
    {
        if ($this->commandExists())
        {
            if(class_exists($this->commandFiles[$this->getCommand()]))
            {
                (new $this->commandFiles[$this->getCommand()]($this->getArgs()))->handle();
            }
        }
    }

    public function commands()
    {
        foreach (glob(__DIR__ . '/Commands/*.php') as $files) {

            $match = $this->matchNamespace($files);

            $file = basename($files, '.php');
            $command = strtolower(str_replace('Command', '', $file));
            $fullClassName = sprintf('%s\\%s', $match[1], $file);

            $this->commandFiles[$command] = $fullClassName;
        }

         return $this->commandFiles;
    }

    public function matchNamespace(string $name) : array
    {
        $namespaceLine = preg_grep('/^namespace /', file($name));
        $namespace = trim(array_shift($namespaceLine));
        preg_match('/^namespace (.*);$/', $namespace, $match);

        return $match;
    }

    public function commandExists() : bool
    {
        return array_key_exists($this->getCommand(),$this->commands());
    }

    /**
     * @param string $command
     */
    public function setCommand(string $command): void
    {
        $this->command = $command ?? null;
    }

    /**
     * @return string
     */
    public function getCommand()
    {
        return $this->command ?? null;
    }

    /**
     * @param array $args
     */
    public function setArgs(array $args): void
    {
        $this->args = $args ?? null;
    }

    /**
     * @return array|null
     */
    public function getArgs(): ?array
    {
        return $this->args ?? null;
    }

    /**
     * @return array
     */
    public function getCommandFiles(): array
    {
        return $this->commandFiles;
    }




}