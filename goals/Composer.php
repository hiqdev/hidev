<?php

/*
 * Highy Integrated Development.
 *
 * @link      https://hiqdev.com/hidev
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hiqdev\hidev\goals;

use Yii;

/**
 * Goal for Composer
 */
class Composer extends Base
{
    public function init()
    {
        $this->add('composer.json', []);
    }
}
