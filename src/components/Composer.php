<?php

namespace hidev\components;

use hidev\helpers\Sys;

class Composer
{
    public function __construct(string $dir)
    {
        $this->dir = ($dir === getcwd() ? '' : $dir);
    }

    public function autoload()
    {
        $path =  $this->getPath('vendor/autoload.php');
        if (!file_exists($path)) {
            $this->run('update');
        }
        require $path;
    }

    public function dump()
    {
        $this->run('dump-autoload');
    }

    public function run(string $command, array $args = [])
    {
        Sys::passthru("{$this->getCmd()} $command");
    }

    public function getCmd(): string
    {
        return 'composer' . ($this->dir ? " -d $dir" : '');
    }

    public function getPath(string $file): string
    {
        if (strncmp($file, '/', 1) === 0) {
            return $file;
        }

        return $this->dir ? $this->dir . DIRECTORY_SEPARATOR . $file : $file;
    }
}
