<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

/**
 * Goal for version file management.
 */
class VersionController extends FileController
{
    protected $_file = 'version';

    public $fileVersion;

    public $version;
    public $date;
    public $time;
    public $zone;
    public $hash;
    public $commit;

    public function init()
    {
        if ($this->exists()) {
            $line = trim($this->getFile()->read());
            list($this->version, $this->date, $this->time, $this->zone, $this->hash) = explode(' ', $line);
            $this->fileVersion = $this->version;
        }
    }

    public function actionMake($version = null)
    {
        $this->setVersion($version);
        $this->actionLoad();
        $this->actionSave();
    }

    public function actionLoad()
    {
        $line = trim($this->exec('git', ['log', '-n', '1', '--pretty=%ai %H %s'])[0]);
        list($this->date, $this->time, $this->zone, $this->hash, $this->commit) = explode(' ', $line, 5);
    }

    public function actionSave()
    {
        $this->getFile()->write(implode(' ', [$this->version, $this->date, $this->time, $this->zone, $this->hash]) . "\n");
    }

    public function setVersion($version = null)
    {
        $this->version = $this->getVersion($version);
    }

    public function getVersion($version = null)
    {
        return $version ?: $this->version ?: 'dev';
    }
}
