<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\base;

use ReflectionClass;
use Yii;
use yii\base\ViewContextInterface;

/**
 * Base for components.
 */
class Component extends \yii\base\Component implements ViewContextInterface
{
    use GettersTrait;

    public function render($view, $params = [])
    {
        return Yii::$app->getView()->render($view, array_merge([
            'app' => Yii::$app,
            'config' => Yii::$app,
            'component' => $this,
        ], $params), $this);
    }

    public function getViewPath()
    {
        $ref = new ReflectionClass($this);

        return dirname(dirname($ref->getFileName())) . '/views';
    }
}
