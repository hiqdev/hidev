<?php
/**
 * Automation tool mixed with code generator for easier continuous development.
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\base;

use yii\helpers\Console;

/**
 * XXX TODO REDO to:
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

    public static $levels = [
        'warning' => self::LEVEL_WARNING,
        'error'   => self::LEVEL_ERROR,
        'quiet'   => 0,
    ];

    /**
     * @var integer level to send log messages to stdout
     */
    protected $_spamLevel;

    /**
     * Logs a message to console and then to yii\log\Logger.
     */
    public function log($message, $level, $category = 'application')
    {
        if ($level <= $this->getSpamLevel()) {
            $style = self::$styles[$level];
            if ($style) {
                $message = Console::ansiFormat($message, $style);
            }
            Console::stdout($message . "\n");
        }
        parent::log($message, $level, $category);
    }

    /**
     * Spam level getter. Default `warning` level.
     * @return integer
     */
    public function getSpamLevel()
    {
        if ($this->_spamLevel === null) {
            $this->setSpamLevel('warning');
        }

        return $this->_spamLevel;
    }

    /**
     * Spam level setter.
     * @param integer $value
     */
    public function setSpamLevel($value)
    {
        if (isset(static::$levels[$value])) {
            $value = static::$levels[$value];
        }
        $this->_spamLevel = $value;
    }
}
