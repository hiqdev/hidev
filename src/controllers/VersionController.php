<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
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

    public function actionLoad()
    {
        $v = trim($this->getFile()->read());
        list($this->version, $this->date, $this->time, $this->zone, $this->hash) = explode(' ', $v);
    }

    public function actionSave($version = null)
    {
        list($date, $time, $zone, $hash) = explode(' ', trim(reset($this->exec('git', ['log', '-n', 1, '--pretty=%ai %H']))));
        if ($hash !== $this->hash) {
            $this->version = 'dev';
        }
        $version = $version ?: $this->takeGoal('bump')->version ?: $this->version ?: 'dev';
        $this->getFile()->write(implode(' ', [$version, $date, $time, $zone, $hash]) . "\n");
    }
}
