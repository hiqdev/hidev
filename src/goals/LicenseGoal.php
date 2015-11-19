<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
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
    public function getLicense()
    {
        return $this->package->license;
    }

    public function getTemplate()
    {
        return 'licenses/' . Helper::id2camel($this->license) . '.twig';
    }

    public function getUrl()
    {
        return $this->license === 'proprietary'
            ? 'https://en.wikipedia.org/wiki/Proprietary_software'
            : 'http://choosealicense.com/licenses/' . Helper::camel2id($this->license);
    }
}
