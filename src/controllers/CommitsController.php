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
 * Controller for reading and writing commits history to build CHANGELOG.md.
 */
class CommitsController extends FileController
{
    protected $_before = ['git']; /// TODO must be 'vcs' or detected

    protected $_file = '.hidev/commits.md';

    public $fileType = 'commits';

    protected $_version;

    public function actionBump($version = null)
    {
        $this->_version = $version ?: $this->takeGoal('bump')->version;

        return $this->runActions(['load', 'do-bump', 'save']);
    }

    public function actionDoBump()
    {
        $history = $this->getHistory();
        $new = [];
        $first = true;
        foreach ($history as $tag => $value) {
            if (substr($tag, 0, strlen($this->_version)) === $this->_version) {
                Yii::error('Version already there: ' . $this->_version);
                return 0;
            }
            if ($first) {
                $first = false;
                $new[$tag] = ['tag' => $tag];
                $tag = $this->_version . $this->getHandler()->renderDate('today');
                $value['tag'] = $tag;
            }
            $new[$tag] = $value;
        }

        $this->getHandler()->setHistory($new);

        /// TODO strange shouldn't be needed
        $this->actionSave();
    }

    public function getHistory()
    {
        return $this->getHandler()->getHistory();
    }

    public function getHandler()
    {
        return $this->getFile()->getHandler();
    }
}
