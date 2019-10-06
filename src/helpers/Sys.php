<?php

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
