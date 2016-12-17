<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

if (!defined('HIDEV_VENDOR_DIR')) {
    foreach ([dirname(dirname(__DIR__)) . '/vendor', dirname(dirname(dirname(dirname(__DIR__))))] as $dir) {
        if (file_exists($dir . '/autoload.php')) {
            define('HIDEV_VENDOR_DIR', $dir);
            break;
        }
    }

    if (!defined('HIDEV_VENDOR_DIR')) {
        fwrite(STDERR, "Run composer to set up hidev own dependencies!\n");
        exit(1);
    }

    require HIDEV_VENDOR_DIR . '/autoload.php';
    require HIDEV_VENDOR_DIR . '/yiisoft/yii2/Yii.php';

    Yii::setAlias('@hidev', dirname(__DIR__));
}
