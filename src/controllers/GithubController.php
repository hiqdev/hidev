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

use yii\helpers\Json;

/**
 * Goal for GitHub.
 */
class GithubController extends CommonController
{
    protected $_name;
    protected $_vendor;
    protected $_package;

    /**
     * @var string GitHub OAuth access token
     */
    protected $_token;

    public function setName($value)
    {
        list($vendor, $package) = explode('/', $value, 2);
        $this->_name    = $value;
        $this->_vendor  = $vendor ?: $package;
        $this->_package = $package ?: $vendor;
    }

    public function getName()
    {
        if ($this->_name === null) {
            $this->setName($this->takeGoal('package')->fullName);
        }

        return $this->_name;
    }

    public function setVendor($value)
    {
        $this->_vendor = $value;
    }

    public function getVendor()
    {
        if ($this->_vendor === null) {
            $this->_vendor = $this->takeVendor()->name;
        }

        return $this->_vendor;
    }

    public function actionCreate()
    {
    }

    public function setPackage($value)
    {
        $this->_package = $value;
    }

    public function getPackage()
    {
        if ($this->_package === null) {
            $this->_package = $this->takeGoal('package')->name;
        }

        return $this->_package;
    }

    /**
     * Clone repo from github.
     * TODO this action must be run without `start`.
     * @param string $repo full name vendor/package
     * @return int exit code
     */
    public function actionClone($repo)
    {
        return $this->passthru('git', ['clone', 'git@github.com:' . $repo]);
    }

    public function actionRelease($version = null)
    {
        $this->runRequest('CHANGELOG.md');
        $changelog = $this->takeGoal('CHANGELOG.md');
        $notes = reset($changelog->getFile()->getHandler()->releaseNotes);
        $version = $this->takeGoal('bump')->getVersion($version);

        return $this->request('POST', '/repos/' . $this->getName() . '/releases', [
            'tag_name'  => $version,
            'name'      => $version,
            'body'      => $notes,
        ]);
    }

    public function request($method, $path, $data)
    {
        $url = 'https://api.github.com' . $path;

        return $this->passthru('curl', ['-X', $method, '-H', 'Authorization: token ' . $this->getToken(), '--data', Json::encode($data), $url]);
    }

    public function getToken()
    {
        if ($this->_token === null) {
            $this->_token = $_SERVER['GITHUB_TOKEN'];
        }

        return $this->_token;
    }
}
