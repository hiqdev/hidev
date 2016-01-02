<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
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
                $res = $this->module->runRequest($name);
                if (static::isNotOk($res)) {
                    return $res;
                }
            }
        }

        return 0;
    }

    public function runRequest($request)
    {
        return $request !== null ? $this->module->runRequest($request) : null;
    }

    /**
     * Runs array of requests. Stops on failure and returns exit code.
     * @param null|string|array $requests
     */
    public function runRequests($requests)
    {
        if (is_string($requests)) {
            $requests = [$requests];
        } elseif (!is_array($requests)) {
            return 0;
        }
        foreach ($requests as $request) {
            $res = $this->runRequest($request);
            if (static::isNotOk($res)) {
                return $res;
            }
        }

        return 0;
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
     * @param string $action action id
     * @param int $time microtime when action was done, false for action was not done
     */
    public function markDone($action, $time = null)
    {
        $this->done[$action] = ($time === null || $time === true) ? microtime(1) : $time;
    }

    public function actionPerform($name = null, $path = null)
    {
        Yii::trace("Started: $this->goalName");
        return $this->runActions('deps, make');
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
        return $this->runActions('load, save');
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
            $res = $this->runAction($action);
            if (static::isNotOk($res)) {
                return $res;
            }
        }

        return 0;
    }

    public static function isNotOk($res)
    {
        return is_object($res) ? $res->exitStatus : $res;
    }

    public function options($actionId)
    {
        return array_merge(parent::options($actionId), array_keys(Helper::getPublicVars(get_called_class())));
    }

    /**
     * Prepares given command arguments.
     * @param string|array $args
     * @return string
     */
    public function prepareCommand($args = '')
    {
        if (is_string($args)) {
            $res = ' ' . trim($args);
        } else {
            $res = '';
            foreach ($args as $a) {
                $res .= ' ' . escapeshellarg($a);
            }
        }

        return $res;
    }

    /**
     * Prepares given prog and given arguments and runs it with passthru.
     * @param string $prog
     * @param string $args
     * @return int exit code
     */
    public function passthru($prog, $args = '')
    {
        // die($this->config->install->getBin($prog) . $this->prepareCommand($args));
        passthru($this->config->install->getBin($prog) . $this->prepareCommand($args), $exitcode);
        return $exitcode;
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
