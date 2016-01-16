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
 * Goal for HiDev own version management: show and bump.
 */
class VersionController extends FileController
{
    protected $_file = '@hidev/../version';

    public $version;

    public function actionMake()
    {
        $v = trim($this->getFile()->read());
        list($version, $date, $time, $zone, $hash) = explode(' ', $v);
        echo "HiDev version $version $date $time $hash\n";
    }

    public function actionBump($version = null)
    {
        $gitinfo = reset($this->exec('git', ['log', '-n', 1, '--pretty=%ai %H']));
        $version = $version ?: $this->version ?: $this->takeGoal('bump')->version ?: 'dev';
        $this->getFile()->write("$version $gitinfo\n");
    }
}
