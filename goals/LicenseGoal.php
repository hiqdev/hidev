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

/**
 * Goal for LICENSE.
 */
class LicenseGoal extends TemplateGoal
{
    public function getTemplate()
    {
        return 'licenses/' . Helper::id2camel($this->package->license) . '.twig';
    }
}
