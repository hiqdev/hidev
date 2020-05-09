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

class Sys
{
    public static function mkdir(string $dir)
    {
        self::passthru("mkdir -p $dir");
    }

    public static function chmod($mode, $path)
    {
        self::passthru("sudo chmod $mode $path");
    }

    public static function passthru(string $cmd)
    {
        echo "> $cmd\n";
        $res = \passthru($cmd, $exitcode);
        if ($exitcode) {
            echo "! failed $cmd";
        }
    }
}
