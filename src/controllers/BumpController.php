<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

/**
 * Controller for version bump.
 */
class BumpController extends AbstractController
{
    protected $_before = ['commits'];

    protected $_version;

    public function actionPerform($version = null)
    {
        $this->setVersion($version);
        return $this->perform();
    }

    public function actionMake()
    {
        return $this->runRequests(['commits/bump', 'version', 'CHANGELOG.md']);
    }

    public function actionCommit($version = null)
    {
        $version = $this->getVersion($version);
        $message = "version bump to $version";
        return $this->passthru('git', ['commit', '-am', $message]);
    }

    public function setVersion($value)
    {
        if (isset($value)) {
            $this->_version = $value;
        }
    }

    public function getVersion($version = null)
    {
        return $version ?: $this->_version ?: $this->takeGoal('version')->version;
    }

    public function actionRelease($version = null)
    {
        $this->setVersion($version);
        return $this->runRequests(['bump/commit', 'git/push', 'github/release']);
    }
}
