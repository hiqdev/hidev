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
 * Goal for Composer.
 */
class ComposerGoal extends BaseGoal
{
    public function init()
    {
        $this->setDeps('composer.json');
    }
}
