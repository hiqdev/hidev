<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

/**
 * Abstract controller with collection inside.
 * @author Andrii Vasyliev <sol@hiqdev.com>
 */
abstract class CollectionController extends AbstractController implements \yii\base\Arrayable, \ArrayAccess, \IteratorAggregate
{
    use \hiqdev\yii2\collection\ObjectTrait;
}
