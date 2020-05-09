<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2020, HiQDev (http://hiqdev.com/)
 */

namespace hidev\base;

use ReflectionClass;
use Yii;
use yii\base\ViewContextInterface;

/**
 * A file to be processed with hidev.
 *
 * @property string $minimalPath path to minimal example file
 */
class Module extends \yii\base\Module implements ViewContextInterface
{
    use GettersTrait;

    public function render($view, $params = [])
    {
        return Yii::$app->getView()->render($view, array_merge([
            'module' => $this,
            'config' => Yii::$app->get('config'),
        ], $params), $this);
    }

    public function getViewPath()
    {
        $ref = new ReflectionClass($this);

        return dirname($ref->getFileName()) . '/views';
    }
}
