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
 * Base Goal.
 */
class BaseGoal extends \yii\base\Controller implements \ArrayAccess, \IteratorAggregate, \yii\base\Arrayable
{
    use \hiqdev\collection\CollectionTrait;

    public $defaultAction = 'run';
}
