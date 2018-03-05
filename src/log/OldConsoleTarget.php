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

use Yii;
use yii\helpers\Console;
use yii\log\Logger;

class OldConsoleTarget extends \yii\log\Target
{
    public $exportInterval = 1;

    public static $styles = [
        Logger::LEVEL_WARNING => [Console::FG_YELLOW],
        Logger::LEVEL_ERROR   => [Console::FG_RED],
    ];

    public function export()
    {
        foreach ($this->messages as $message) {
            $this->out($message[0], $message[1]);
        }
    }

    public function out($message, $level)
    {
        if ($level > $this->getLevel()) {
            return;
        }
        $style = self::$styles[$level];
        if ($style) {
            $message = Console::ansiFormat($message, $style);
        }
        Console::stdout($message . "\n");
    }

    public function getLevel()
    {
        return Yii::$app->get('log')->getLevel();
    }

    protected function getContextMessage()
    {
        return '';
    }
}
