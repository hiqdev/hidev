<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hidev\log;

use Psr\Log\LogLevel;
use yii\helpers\Console;

class ConsoleTarget extends \yii\log\Target
{
    public $exportInterval = 1;

    public static $styles = [
        LogLevel::EMERGENCY => [Console::FG_RED],
        LogLevel::ALERT     => [Console::FG_RED],
        LogLevel::CRITICAL  => [Console::FG_RED],
        LogLevel::ERROR     => [Console::FG_RED],
        LogLevel::WARNING   => [Console::FG_YELLOW],
    ];

    public function export()
    {
        foreach ($this->messages as $message) {
            $this->out($message[0], $message[1]);
        }
    }

    public function out($level, $message)
    {
        /* XXX add minimum log severity to show
         * if ($level > $this->getLevel()) {
            return;
        }*/
        $style = self::$styles[$level];
        if ($style) {
            $message = Console::ansiFormat($message, $style);
        } else {
            return;
        }
        Console::stdout($message . "\n");
    }

    protected function getContextMessage()
    {
        return '';
    }
}
