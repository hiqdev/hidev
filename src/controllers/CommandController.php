<?php

/*
 * Build tool mixed with code generator for easier automation and continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

use Yii;

/**
 * Command controller.
 */
class CommandController extends CommonController
{
    public $path;
    public $sudo;
    public $command;
    public $comment;

    protected $_cwd;

    public function setCommands($value)
    {
        $this->command = $value;
    }

    public function actionSave()
    {
        $commands = explode("\n", $this->command);
        foreach ($commands as $command) {
            $command = trim($command);
            if ($command) {
                passthru(($this->sudo ? 'sudo ' : '') . $command);
            }
        }
    }

    public function actionBefore()
    {
        $this->_cwd = getcwd();
        chdir(Yii::getAlias($this->path));
        parent::actionBefore();
    }

    public function actionAfter()
    {
        parent::actionAfter();
        chdir($this->_cwd);
    }
}
