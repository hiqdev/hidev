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
 * Update goal.
 */
class UpdateController extends CommonController
{
    public function actionMake()
    {
        $this->makeUpdate();
        $this->module->runRequest('');
    }

    public function makeUpdate()
    {
        $this->passthru('composer', ['update', '-d', '.hidev', '--prefer-source', '--ansi']);
    }
}
