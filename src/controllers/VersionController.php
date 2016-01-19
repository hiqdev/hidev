<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

/**
 * Goal for version file management.
 */
class VersionController extends FileController
{
    protected $_file = 'version';

    public $version;
    public $date;
    public $time;
    public $zone;
    public $hash;

    public function init()
    {
        $v = trim($this->getFile()->read());
        list($this->version, $this->date, $this->time, $this->zone, $this->hash) = explode(' ', $v);
    }

    public function actionMake($version = null)
    {
        $v = trim($this->exec('git', ['log', '-n', '1', '--pretty=%ai %H %s'])[0]);
        list($date, $time, $zone, $hash, $commit) = explode(' ', $v, 5);
        if ($commit !== 'version bump to ' . $this->version) {
            if ($hash !== $this->hash) {
                $this->version = 'dev';
            }
            $version = $version ?: $this->takeGoal('bump')->version ?: $this->version ?: 'dev';
            $this->getFile()->write(implode(' ', [$version, $date, $time, $zone, $hash]) . "\n");
        }
    }
}
