<?php
/**
 * Automation tool mixed with code generator for easier continuous development.
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

require_once __DIR__ . '/defines.php';

if (!defined('HIDEV_VENDOR_DIR')) {
    foreach ([dirname(dirname(__DIR__)) . '/vendor', dirname(dirname(dirname(dirname(__DIR__))))] as $dir) {
        if (file_exists($dir . '/autoload.php')) {
            define('HIDEV_VENDOR_DIR', $dir);
            break;
        }
    }
}

if (!defined('HIDEV_VENDOR_DIR') || !file_exists(HIDEV_VENDOR_DIR . '/autoload.php')) {
    fwrite(STDERR, "Run composer to set up dependencies!\n");
    exit(1);
}

require_once HIDEV_VENDOR_DIR . '/autoload.php';
require_once HIDEV_VENDOR_DIR . '/yiisoft/yii2/Yii.php';

Yii::setAlias('@hidev', dirname(__DIR__));
Yii::setAlias('@vendor', HIDEV_VENDOR_DIR);
