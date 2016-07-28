<?php

/*
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

/**
 * Goal for HiDev own version output.
 */
class OwnVersionController extends VersionController
{
    protected $_file = '@hidev/../version';

    public $version;
    public $date;
    public $time;
    public $zone;
    public $hash;

    public function actionMake($version = null)
    {
        echo "HiDev version $this->version $this->date $this->time $this->hash\n";
    }
}
