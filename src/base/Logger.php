<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (http://hiqdev.com/)
 */

namespace hidev\base;

use yii\console\Helper as Console;

/**
 * ConsoleTarget sends selected log messages to the console stdout.
 *
 * ```php
 * 'components' => [
 *     'log' => [
 *          'targets' => [
 *              [
 *                  'class' => 'yii\log\ConsoleTarget',
 *                  'levels' => ['error', 'warning'],
 *              ],
 *          ],
 *     ],
 * ],
 * ```
 */
class Logger extends \yii\log\Logger
{
    public static $styles = [
        self::LEVEL_WARNING => [Console::FG_YELLOW],
        self::LEVEL_ERROR   => [Console::FG_RED],
    ];

    /**
     * Logs a message to console and then to yii\log\Logger.
     */
    public function log($message, $level, $category = 'application')
    {
        if ($level <= static::LEVEL_WARNING) {
            $style = self::$styles[$level];
            if ($style) {
                $message = Console::ansiFormat($message, $style);
            }
            Console::stdout($message . "\n");
        }
        parent::log($message, $level, $category);
    }
}
