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

/**
 * Goal for README.
 */
class ChangelogGoal extends TemplateGoal
{
    protected $_fileType = 'changelog';

    public function init()
    {
        $this->setDeps('commits');
    }

    public function getTemplate()
    {
        return 'CHANGELOG';
    }
}
