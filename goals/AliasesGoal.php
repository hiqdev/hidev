<?php

/*
 * HiDev - integrate your development
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hidev\goals;

use hidev\helpers\Helper;

class AliasesGoal extends \hiqdev\collection\Object
{
    public $name;

    public function getItem($name)
    {
        return Helper::csplit(parent::getItem($name), ' ');
    }
}
