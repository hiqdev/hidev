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

/**
 * Goal for LICENSE
 */
class License extends Template
{
    public function getTemplate()
    {
        return 'licenses/' . Helper::id2camel($this->package->license) . '.twig';
    }
}
