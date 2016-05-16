<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE);

require __DIR__ . '/../src/config/bootstrap.php';

foreach (require __DIR__ . '/../.hidev/vendor/hiqdev/aliases.php' as $alias => $path) {
    Yii::setAlias($alias, $path);
}
