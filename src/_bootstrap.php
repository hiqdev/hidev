<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

if (!defined('HIDEV_DIR')) {
    foreach ([dirname(__DIR__) . '/vendor', dirname(dirname(dirname(__DIR__)))] as $dir) {
        if (file_exists($dir . '/autoload.php')) {
            define('HIDEV_VENDOR_DIR', $dir);
            break;
        }
    }

    if (!defined('HIDEV_VENDOR_DIR')) {
        fwrite(STDERR, "Run composer to set up hidev own dependencies!\n");
        exit(1);
    }

    require_once HIDEV_VENDOR_DIR . '/autoload.php';
    require_once HIDEV_VENDOR_DIR . '/yiisoft/yii2/Yii.php';
}
