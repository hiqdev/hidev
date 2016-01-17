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

    public function actionMake()
    {
        echo "HiDev version $this->version $this->date $this->time $this->hash\n";
    }
}
