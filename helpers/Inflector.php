<?php

/*
 * HiDev
 *
 * @link      https://hiqdev.com/hidev
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hiqdev\hidev\helpers;

use Yii;

/**
 * Hidev Inflector.
 */
class Inflector extends \yii\helpers\BaseInflector
{
    public static function dot2sep($str, $separator = '-')
    {
        return str_replace('.',$separator,$str);
    }

    public static function id2camel($id, $separator = '-')
    {
        return parent::id2camel(strtolower(static::dot2sep($id,$separator)), $separator);
    }

    public static function file2template($file, $separator = '-')
    {
        return static::dot2sep($file, $separator);
    }
}
