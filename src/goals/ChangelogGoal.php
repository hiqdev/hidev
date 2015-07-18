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
 * Goal for CHANGELOG.md file.
 */
class ChangelogGoal extends FileGoal
{
    protected $_fileType = 'changelog';

    public function init()
    {
        $this->setDeps('commits');
    }
}
