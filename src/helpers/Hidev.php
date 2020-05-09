<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2020, HiQDev (http://hiqdev.com/)
 */

namespace hidev\helpers;

/**
 * Hidev helper.
 */
class Hidev
{
    public static function exec($route, array $args, $wait = false)
    {
        $path = dirname(__DIR__) . '/bin/hidev';
        $command = "$path $route";
        foreach ($args as $arg) {
            $command .= ' ' . escapeshellarg($arg);
        }
        $amp = $wait ? '' : '&';

        return exec("$command > /dev/null 2>&1 $amp");
    }
}
