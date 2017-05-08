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

use Yii;

/**
 * Command goal.
 * Holds and executes commands.
 */
class Command extends \hidev\base\Component
{
    public $path;
    public $sudo;
    public $comment;
    public $commands;

    protected $_cwd;

    public function setCommand($value)
    {
        $this->commands = $value;
    }

    public function getCommands()
    {
        if (!is_array($this->commands)) {
            $this->commands = explode("\n", $this->commands);
        }

        return $this->commands;
    }

    public function save()
    {
        $this->before();
        foreach ($this->getCommands() as $command) {
            $command = trim($command);
            if ($command) {
                passthru(($this->sudo ? 'sudo ' : '') . $command);
            }
        }
        $this->after();
    }

    public function before()
    {
        $this->_cwd = getcwd();
        if ($this->path) {
            chdir(Yii::getAlias($this->path));
        }
    }

    public function after()
    {
        chdir($this->_cwd);
    }
}
