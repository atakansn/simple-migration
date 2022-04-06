<?php

namespace SimpleMigration\Helpers;

class FileSystem
{
    public function directoryExists(string $path, int $permission = 0755, bool $recursive = true, bool $force = false)
    {
        if(!is_dir($path))
        {
            if($force)
            {
                return mkdir($path,$permission,$recursive);
            }

            return mkdir($path,$permission,$recursive);
        }
    }

    public function put(string $path, mixed $data)
    {
        return file_put_contents($path,$data);
    }

    public function basename(string $path, string $suffix = "")
    {
        return basename($path,$suffix);
    }

    public function get(string $fileName)
    {
        return file_get_contents($fileName);
    }

    public function exists($path)
    {
        return file_exists($path);
    }

}