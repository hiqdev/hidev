<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (http://hiqdev.com/)
 */

namespace hidev\goals;

use Yii;

/**
 * Update goal.
 */
class InstallGoal extends DefaultGoal
{
    public function actionMake()
    {
        Yii::warning('install');
    }

    public function actionUpdate()
    {
        exec('cd .hidev;composer update --prefer-source');
        $this->module->runRequest('');
    }
}
