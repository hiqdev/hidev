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

/**
 * Goal for Composer
 */
class ComposerGoal extends BaseGoal
{
    public function init()
    {
        $this->setDeps('composer.json');
    }
}
