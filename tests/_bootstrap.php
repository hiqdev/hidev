<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (http://hiqdev.com/)
 */

error_reporting(-1);

define('YII_ENABLE_ERROR_HANDLER', false);
define('YII_DEBUG', true);
$_SERVER['SCRIPT_NAME']     = '/' . __DIR__;
$_SERVER['SCRIPT_FILENAME'] = __FILE__;
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
Yii::setAlias('@hidev', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src');
Yii::setAlias('@hidev/bin', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bin');
Yii::setAlias('@hidev/tests', __DIR__);
