<?php

namespace hidev\tests\functional;

use Yii;

class Tester
{
    public $test;

    public $dir;

    public function __construct($test)
    {
        static $no = 0;
        $no++;
        $this->test = $test;
        $this->now = date("c");
        $this->dir = $this->path($this->now . '-' . $no, Yii::getAlias('@hidev/tests/_output'));
        mkdir($this->dir);
        chdir($this->dir);
    }

    public function path($file, $dir = null)
    {
        return ($dir ?: $this->dir) . DIRECTORY_SEPARATOR . $file;
    }

    public function __destruct()
    {
        #exec('rm -rf ' . $this->dir);
    }

    public function hidev($params)
    {
        $command = Yii::getAlias('@hidev/bin/hidev') . ' ' . $params;
        exec($command);
    }

    public function assertFile($file, $content)
    {
        $this->test->assertEquals(trim($this->readFile($file)), trim($content));
    }

    public function writeFile($file, $contents)
    {
        file_put_contents($this->path($file), $contents);
    }

    public function appendFile($file, $contents)
    {
        $this->writeFile($file, $this->readFile($file) . $contents);
    }

    public function readFile($file)
    {
        return file_get_contents($this->path($file));
    }
}
