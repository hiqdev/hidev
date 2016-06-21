<?php

/*
 * Build tool mixed with code generator for easier automation and continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\base;

/**
 * Basic controller.
 */
class Controller extends \yii\console\Controller
{
    public $defaultAction = 'perform';

    public $layout = false;
}
