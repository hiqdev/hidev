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

use Yii;

/**
 * Version goal.
 */
class VersionController extends CommonController
{
    public function actionMake()
    {
        $v = file_get_contents(Yii::getAlias('@hidev/../version'));
        list($version, $hash, $date, $time, $zone) = explode(' ', $v);
        echo "HiDev version $version $date $time\n";
    }
}
