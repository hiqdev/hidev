<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hidev\helpers;

/**
 * Composer config plugin helper.
 */
class ConfigPlugin
{
    public static function path($name, $vendor)
    {
        /// doesn't work when dependencies are not installed
        /// return \hiqdev\composer\config\Builder::path($name, $vendor);
        return "$vendor/hiqdev/composer-config-plugin-output/$name.php";
    }
}
