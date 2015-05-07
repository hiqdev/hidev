<?php

/*
 * Highy Integrated Development.
 *
 * @link      https://hiqdev.com/hidev
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hiqdev\hidev\goals;

use Yii;
use hiqdev\hidev\helpers\Helper;

class Aliases extends \hiqdev\collection\Object
{
    public $name;

    public function getItem($name)
    {
        return Helper::csplit(parent::getItem($name),' ');
    }

}
