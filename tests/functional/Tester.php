<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (http://hiqdev.com/)
 */

namespace hidev\tests\functional;

use Yii;

class Tester
{
    public $test;

    public $dir;

    public function __construct($test)
    {
        static $no = 0;
        ++$no;
        $this->test = $test;
        $this->now  = date('c', $this->getTime());
        $this->dir  = $this->path($this->now . '-' . $no, Yii::getAlias('@hidev/tests/_output'));
        mkdir($this->dir);
        chdir($this->dir);
    }

    public static $time;

    public function getTime()
    {
        if (self::$time === null) {
            self::$time = time();
        }

        return self::$time;
    }

    public function path($file, $dir = null)
    {
        $path = ($dir ?: $this->dir) . DIRECTORY_SEPARATOR . $file;
        $dirname = dirname($path);
        if (!file_exists($dirname)) {
            mkdir($dirname, 0777, true);
        }
        return $path;
    }

    public function __destruct()
    {
        exec('rm -rf ' . $this->dir);
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

    public function assertFileHas($file, array $strings)
    {
        $contents = trim($this->readFile($file));
        foreach ($strings as $s) {
            $this->test->assertNotSame(strpos($contents, $s), false, "Has NOT: $s");
        }
    }

    public function writeFile($file, $contents)
    {
        file_put_contents($this->path($file), rtrim($contents) . "\n");
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
