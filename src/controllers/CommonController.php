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

use Yii;

/**
 * Common controller.
 */
class CommonController extends AbstractController
{
    public function actionPerform($name = null, $path = null)
    {
        Yii::trace("Started: '$this->id'");
        return $this->perform(['before', 'make', 'after']);
    }
}
