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

use hidev\helpers\Helper;
use Yii;

/**
 * Default Goal.
 */
class DefaultGoal extends BaseGoal
{
    public $goalName;

    public $done = false;

    protected $_fileType = null;

    public $vcsignore;

    public function init()
    {
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

    public function actionPerform()
    {
        if ($this->done) {
            Yii::trace("Already done: $this->goalName");

            return;
        }
        Yii::trace("Started: $this->goalName");
        $this->actionDeps();
        $this->actionMake();
        $this->done = true;
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
        $this->actionLoad();
        $this->actionSave();
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
        return $this->getConfig()->getItem('git');
    }
}
