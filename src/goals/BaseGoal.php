<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\goals;

/**
 * Base Goal.
 */
class BaseGoal extends \yii\console\Controller implements \ArrayAccess, \IteratorAggregate, \yii\base\Arrayable
{
    use \hiqdev\yii2\collection\ObjectTrait;

    public $defaultAction = 'perform';
}
