<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

/**
 * Goal for GitHub.
 */
class GithubController extends CommonController
{
    protected $_name;
    protected $_vendor;
    protected $_package;

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
            $this->setName($this->getGoal('package')->fullName);
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
            $this->_vendor = $this->getVendor()->name;
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
            $this->_package = $this->getGoal('package')->name;
        }

        return $this->_package;
    }

    /**
     * Clone repo from github.
     * TODO to work need to redo HiDev to run this action without normal initilization.
     * @param string $repo full name vendor/package
     * @return int exit code
     */
    public function actionClone($repo)
    {
        return $this->passthru('git', ['clone', 'git@github.com:' . $repo]);
    }
}
