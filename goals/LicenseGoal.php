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

use hidev\helpers\Helper;

/**
 * Goal for LICENSE
 */
class LicenseGoal extends TemplateGoal
{
    public function getTemplate()
    {
        return 'licenses/' . Helper::id2camel($this->package->license) . '.twig';
    }
}
