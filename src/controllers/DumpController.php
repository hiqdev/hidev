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
class DumpController extends CommonController
{
    public function actionMake()
    {
        $data = Yii::$app->controllerMap;
        echo Yaml::dump(ArrayHelper::toArray($data), 4);
    }

    public function actionInternals()
    {
        $internals = [
            'aliases' => Yii::$aliases,
            'view.theme.pathMap' => Yii::$app->view->theme->pathMap,
        ];
        echo Yaml::dump($internals, 4);
    }
}
