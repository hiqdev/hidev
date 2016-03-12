<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

foreach ([__DIR__ . '/vendor/autoload.php', __DIR__ . '/../../autoload.php', __DIR__ . '/../vendor/autoload.php'] as $file) {
    if (file_exists($file)) {
        define('HIDEV_AUTOLOAD_FILE', $file);
        break;
    }
}

if (!defined('HIDEV_AUTOLOAD_FILE')) {
    fwrite(STDERR, "Run composer to set up hidev own dependencies!\n");
    exit(1);
}

require HIDEV_AUTOLOAD_FILE;
