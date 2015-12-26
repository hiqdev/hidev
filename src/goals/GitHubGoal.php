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

/**
 * Goal for GitHub.
 */
class GitHubGoal extends DefaultGoal
{
    public function setName($value)
    {
        list($vendor, $package) = explode('/', $value, 2);
        $this->setItem('name',    $value);
        $this->setItem('vendor',  $vendor ?: $package);
        $this->setItem('package', $package ?: $vendor);
    }

    public function getName()
    {
        return $this->getItem('name') ?: $this->config->package->fullName;
    }

    public function getPackage()
    {
        return $this->getItem('package') ?: $this->config->package->name;
    }

    public function getVendor()
    {
        return $this->getItem('vendor') ?: $this->config->vendor->name;
    }

    public function actionCreate()
    {
    }

    /**
     * Clone repo from github.
     * TODO to work need to redo HiDev to run this action without normal initilization.
     * @param string $repo full name vendor/package
     * @return int exit code
     */
    public function actionClone($repo)
    {
        return $this->passthru('git', ['clone', 'git@github.com:' . $repo);
    }
}
