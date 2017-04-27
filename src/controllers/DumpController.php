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
use yii\helpers\ArrayHelper;

/**
 * Dump goal.
 */
class DumpController extends \yii\console\Controller
{
    public function actionIndex($name = null)
    {
        $data = Yii::$app->controllerMap;
        if ($name) {
            if (empty($data[$name])) {
                echo "'$name' not defined\n";
                return;
            }
            $data = [$name => $data[$name]];
        }
        echo Yaml::dump($data, 4);
    }

    public function actionInternals()
    {
        $internals = [
            'aliases' => Yii::$aliases,
            'view.theme.pathMap' => Yii::$app->view->theme->pathMap,
            'components' => Yii::$app->getComponents(),
        ];
        echo Yaml::dump($internals, 4);
    }

    public function actionComponents()
    {
        echo Yaml::dump(Yii::$app->getComponents(), 4);
    }
}
