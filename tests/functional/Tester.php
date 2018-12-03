<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hidev\tests\functional;

use yii\helpers\Yii;
use yii\console\Application;
use yii\console\Request;

class Tester
{
    public $dir;

    public $test;

    public $clean = true;

    protected $_app;

    public function __construct($test)
    {
        if (!Yii::getAlias('@app', false)) {
            $this->loadAliases('./vendor/hiqdev/config/aliases.php');
            $this->loadAliases('./.hidev/vendor/hiqdev/config/aliases.php');
        }
        static $no = 0;
        ++$no;
        $this->test = $test;
        $this->now  = date('c', $this->getTime());
        $this->dir  = $this->path($this->now . '-' . $no, Yii::getAlias('@hidev/tests/_output'));
        static::mkdir($this->dir);
        chdir($this->dir);
    }

    public static $time;

    public function loadAliases($file)
    {
        if (!file_exists($file)) {
            return;
        }
        foreach (require($file) as $alias => $path) {
            Yii::setAlias($alias, $path);
        }
    }

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
        static::mkdir($dirname);

        return $path;
    }

    public function __destruct()
    {
        if ($this->clean) {
            exec('rm -rf ' . $this->dir);
        }
    }

    /**
     * Run hidev.
     * @param string $query
     */
    public function hidev($query)
    {
        //$command = Yii::getAlias('@hidev/../bin/hidev') . ' ' . $params;
        //exec($command);
        $request = Yii::createObject([
            'class'  => Request::class,
            'params' => is_array($query) ? $query : array_filter(explode(' ', $query)),
        ]);

        $this->getApp()->handleRequest($request);
    }

    public function setAlias($alias, $path)
    {
        Yii::setAlias($alias, $path);
    }

    /**
     * Returns Application, creates if necessary.
     * @return Application
     */
    public function getApp()
    {
        if ($this->_app === null) {
            $config = require Yii::getAlias('@hidev/../config/basis.php');
            unset($config['components']['log']);
            $this->_app = new Application($config);
        }

        return $this->_app;
    }

    /**
     * Writes configuration file for sample hidev.
     * @param string $content the configuration
     * @param array $subs
     */
    public function config($content, array $subs = null)
    {
        if ($content[0] === '/' && file_exists($content)) {
            $content = file_get_contents($content);
        }
        if (!empty($subs)) {
            $content = strtr($content, $subs);
        }
        static::mkdir('.hidev');
        $this->writeFile('.hidev/config.yml', $content);
    }

    public function assertFile($content, $file, array $subs = null)
    {
        if ($content[0] === '/' && file_exists($content)) {
            $content = file_get_contents($content);
        }
        if (!empty($subs)) {
            $content = strtr($content, $subs);
        }
        $this->test->assertEquals(trim($content), trim($this->readFile($file)));
    }

    public function assertFiles($dir, $files, array $subs = [])
    {
        foreach ($files as $file) {
            $path = $dir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($path)) {
                $fs = [];
                foreach (scandir($path) as $f) {
                    if ($f !== '.' && $f !== '..') {
                        $fs[] = $file . DIRECTORY_SEPARATOR . $f;
                    }
                }
                $this->assertFiles($dir, $fs, $subs);
            } else {
                $this->assertFile($path, $file, $subs);
            }
        }
    }

    public function assertFileHas(array $strings, $file)
    {
        $contents = trim($this->readFile($file));
        foreach ($strings as $s) {
            $this->test->assertNotSame(strpos($contents, $s), false, "Has NOT: $s");
        }
    }

    /**
     * Write file.
     * @param string $file relative path to file
     * @param string $contents to be written or path to file or dir
     */
    public function writeFile($file, $contents)
    {
        if (file_exists($contents)) {
            $contents = file_get_contents($contents . DIRECTORY_SEPARATOR . $file);
        } elseif (file_exists($contents)) {
            $contents = file_get_contents($contents);
        }
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

    public static function mkdir($dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }
}
