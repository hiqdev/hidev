<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hidev\base;

use ReflectionClass;
use yii\base\Application;
use yii\view\ViewContextInterface;

/**
 * Base for components.
 */
class Component extends \yii\base\Component implements ViewContextInterface
{
    use GettersTrait;

    /**
     * @var Application
     */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function render($view, $params = [])
    {
        return $this->app->getView()->render($view, array_merge([
            'app' => $this->app,
            'config' => $this->app,
            'component' => $this,
        ], $params), $this);
    }

    public function getViewPath()
    {
        $ref = new ReflectionClass($this);

        return dirname(dirname($ref->getFileName())) . '/views';
    }
}
