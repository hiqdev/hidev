<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (http://hiqdev.com/)
 */

namespace hidev\goals;

use hidev\helpers\Helper;

class AliasesGoal extends DefaultGoal
{
    public function getItem($name)
    {
        return Helper::csplit(parent::getItem($name), ' ');
    }
}
