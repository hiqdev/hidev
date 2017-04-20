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
        $data = $this->takeConfig()->getItems();
        unset($data['dump'], $data['start']);
        echo Yaml::dump(ArrayHelper::toArray($data), 4);
    }

    public function actionInternals()
    {
        $internals = [
            'aliases'   => Yii::$aliases,
        ];
        echo Yaml::dump($internals, 4);
    }
}
