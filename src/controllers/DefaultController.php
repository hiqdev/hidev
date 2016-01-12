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
 * Default goal.
 */
class DefaultController extends CommonController
{
    public function actionMake()
    {
        return StartController::$started ? parent::actionMake() : $this->runRequests(['start', 'default']);
    }
}
