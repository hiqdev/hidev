<?php

/*
 * HiDev - integrate your development
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hidev\goals;

use Yii;
use yii\base\InvalidParamException;

/**
 * The Config. Keeps the Goals.
 */
class ParentGoal extends FileGoal
{
    use \Robo\Task\Vcs\loadTasks;

    public $name;

    protected $_file = '@parent/config.yml';

    protected $_defined;

    protected $_github;

    public function setGithub($github)
    {
        if ($this->_defined) {
            throw new InvalidParamException('Already defined: ' . $this->_defined);
        }
        $this->_github  = $github;
        $this->_defined = 'github';
        if (static::exists($this->file->dirname)) {
            return;
        }
        $task = $this->taskGitStack()
            ->stopOnFail()
            ->cloneRepo("git@github.com:$github", $this->file->dirname);
        if (!$task->run()->wasSuccessful()) {
            throw new InvalidParamException('Failed clone parent');
        }
    }

    public function getGithub()
    {
        return $this->_github;
    }

    public function getDefined()
    {
        return $this->_defined;
    }

    public function actionUpdate()
    {
        $dir = Yii::getAlias('@parent');
        passthru("cd $dir;git pull");
    }
}
