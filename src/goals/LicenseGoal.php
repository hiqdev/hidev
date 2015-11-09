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

/**
 * Goal for LICENSE.
 */
class LicenseGoal extends TemplateGoal
{
    public function getTemplate()
    {
        return 'licenses/' . Helper::id2camel($this->package->license) . '.twig';
    }

    public function getUrl()
    {
        return 'http://choosealicense.com/licenses/' . Helper::camel2id($this->package->license);
    }
}
