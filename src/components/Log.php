<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\components;

use yii\log\Logger;

/**
 * Log dispatcher component.
 */
class Log extends \yii\log\Dispatcher
{
    protected $_level = Logger::LEVEL_WARNING;

    protected $levels = [
        'error'     => Logger::LEVEL_ERROR,
        'warning'   => Logger::LEVEL_WARNING,
        'info'      => Logger::LEVEL_INFO,
    ];

    protected $names;

    public function setLevel($value)
    {
        if (isset($this->levels[$value])) {
            $this->_level = $this->levels[$value];
            return;
        }
        if (in_array($value, $this->levels, false)) {
            $this->_level = $value;
        }

        Yii::warning("wrong log level: $value");
    }

    public function getLevel()
    {
        return $this->_level;
    }

    public function getLevelName($level = null)
    {
        if ($level === null) {
            $level = $this->_level;
        }
        return isset($this->levelNames[$level]) ? $this->levelNames[$level] : null;
    }

    public function getLevelNames()
    {
        if ($this->names === null) {
            $this->names = array_flip($this->levels);
        }

        return $this->names;
    }
}
