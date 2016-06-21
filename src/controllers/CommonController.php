<?php

/*
 * Build tool mixed with code generator for easier automation and continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

use Yii;

/**
 * Common controller.
 */
class CommonController extends AbstractController
{
    public $performName;
    public $performPath;

    public function actionPerform($name = null, $path = null)
    {
        $this->performName = $name;
        $this->performPath = $path;
        Yii::trace("Started: '$this->id'");
        return $this->perform();
    }
}
