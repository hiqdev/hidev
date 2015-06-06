<?php

/*
 * Highy Integrated Development.
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hidev\goals;

use Yii;
use hidev\helpers\Helper;

class AliasesGoal extends \hiqdev\collection\Object
{
    public $name;

    public function getItem($name)
    {
        return Helper::csplit(parent::getItem($name),' ');
    }

}
