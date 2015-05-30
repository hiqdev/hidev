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

/**
 * Goal for Composer
 */
class Composer extends Base
{
    public function init()
    {
        $this->setDeps('composer.json');
    }
}
