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

use Symfony\Component\Yaml\Yaml;
use Yii;

/**
 * Dump available definitions: components, controllers, aliases.
 */
class DumpController extends \yii\console\Controller
{
    public $defaultAction = 'component';

    /**
     * Dump defined components.
     * @param string $name component name
     */
    public function actionComponent($name = null)
    {
        $data = Yii::$app->getComponents();
        if ($name) {
            if (empty($data[$name])) {
                Yii::error("'$name' not defined");
                return;
            }
            $data = [$name => $data[$name]];
        }
        echo Yaml::dump($data, 4);
    }

    /**
     * Dump defined controllers.
     * @param string $name controller name
     */
    public function actionController($name = null)
    {
        $data = Yii::$app->controllerMap;
        if ($name) {
            if (empty($data[$name])) {
                Yii::error("'$name' not defined");
                return;
            }
            $data = [$name => $data[$name]];
        }
        echo Yaml::dump($data, 4);
    }

    /**
     * Dump defined aliases.
     * @param string $alias alias to resolve
     */
    public function actionAlias($alias = null)
    {
        $data = Yii::$aliases;
        if ($alias) {
            $dest = Yii::getAlias($alias, false);
            if (empty($dest)) {
                Yii::error("'$alias' not defined");
                return;
            }
            $data = [$alias => $dest];
        }
        echo Yaml::dump($data, 4);
    }
}
