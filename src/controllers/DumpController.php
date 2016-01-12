<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

use yii\helpers\ArrayHelper;
use Symfony\Component\Yaml\Yaml;

/**
 * Dump goal.
 */
class DumpController extends CommonController
{
    protected $_before = ['start'];

    public function actionMake()
    {
        $data = $this->getConfig()->getItems();
        print Yaml::dump(ArrayHelper::toArray($data), 4);
    }
}
