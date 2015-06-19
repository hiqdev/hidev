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
 * Goal for VCS (Version Control Systems).
 */
class VcsGoal extends BaseGoal
{
    public $lastTag = 'Under development';

    public $initTag = 'Development started';
}
