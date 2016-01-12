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

use hidev\helpers\Helper;

class AliasesController extends CommonController
{
    public function getItem($name)
    {
        return Helper::csplit(parent::getItem($name), ' ');
    }
}
