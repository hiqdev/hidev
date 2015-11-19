<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (http://hiqdev.com/)
 */

namespace hidev\goals;

use hidev\helpers\Helper;
use Yii;

/**
 * Default Goal.
 */
class DefaultGoal extends BaseGoal
{
    public $goalName;

    public $done = [];

    protected $_fileType = null;

    public $vcsignore;

    public function init()
    {
        parent::init();
        if ($this->vcsignore) {
            $this->vcs->setIgnore($this->vcsignore, 'first');
        }
    }

    public function getFileType()
    {
        return $this->_fileType;
    }

    public function setFileType($type)
    {
        $this->_fileType = $type;
    }

    public function setDeps($deps)
    {
        $res = $this->getDeps();
        foreach (Helper::ksplit($deps) as $d => $e) {
            $res[is_int($d) ? $e : $d] = $e;
        }
        $this->setItem('deps', $res);
    }

    public function getDeps()
    {
        return Helper::ksplit($this->rawItem('deps'));
    }

    public function actionDeps()
    {
        foreach ($this->getDeps() as $name => $enabled) {
            if ($enabled) {
                $this->module->runRequest($name);
            }
        }
    }

    public function isDone($action, $timestamp = null)
    {
        if ($this->done[$action]) {
            Yii::trace("Already done: $this->goalName/$action");

            return true;
        }

        return false;
    }

    /**
     * Mark action as already done.
     *
     * @param $action action id
     * @param $time microtime when action was done, false for action was not done
     */
    public function markDone($action, $time = null)
    {
        $this->done[$action] = ($time === null || $time === true) ? microtime(1) : $time;
    }

    public function actionPerform()
    {
        Yii::trace("Started: $this->goalName");
        $this->runActions('deps, make');
    }

    public function actionLoad()
    {
        Yii::trace("Loading nothing for '$this->goalName'");
    }

    public function actionSave()
    {
        Yii::trace("Saving nothing for '$this->goalName'");
    }

    public function actionMake()
    {
        $this->runActions('load, save');
    }

    public function runAction($id, $params = [])
    {
        if ($this->isDone($id)) {
            return;
        }
        $result = parent::runAction($id, $params);
        $this->markDone($id);

        return $result;
    }

    public function runActions($actions)
    {
        foreach (Helper::ksplit($actions) as $action) {
            $result = $this->runAction($action);
        }

        return $result;
    }

    public function options($actionId)
    {
        return array_merge(parent::options($actionId), array_keys(Helper::getPublicVars(get_called_class())));
    }

    public function getRobo()
    {
        return Yii::$app->get('robo');
    }

    public function getConfig()
    {
        return Yii::$app->get('config');
    }

    public function getPackage()
    {
        return $this->getConfig()->getItem('package');
    }

    public function getVendor()
    {
        return $this->getConfig()->getItem('vendor');
    }

    public function getVcs()
    {
        /// TODO determine VCS
        return $this->getConfig()->getItem('git');
    }
}
