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
 * Goal for LICENSE
 */
class License extends Template
{
    public function getTemplate()
    {
        return 'licenses/' . $this->config->package->license;
    }
}
