<?php

namespace hidev\base;

use yii\helpers\Console;

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
        Logger::LEVEL_WARNING  => [Console::FG_YELLOW],
        Logger::LEVEL_ERROR    => [Console::FG_RED],
    ];

    /**
     * Logs a message to console and then to yii\log\Logger
     */
    public function log($message, $level, $category = 'application')
    {
        if ($level <= static::LEVEL_WARNING) {
            $style = self::$styles[$level];
            if ($style) {
                $message = Console::ansiFormat($message, $style);
            }
            Console::stdout($message."\n");
        }
        parent::log($message, $level, $category);
    }
}
