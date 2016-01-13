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
 * Controller for reading and writing commits history to build CHANGELOG.md.
 */
class CommitsController extends FileController
{
    protected $_before = ['git']; /// TODO must be 'vcs' or detected

    protected $_file = '.hidev/commits.md';

    public $fileType = 'commits';

    public function getHistory()
    {
        return $this->getFile()->getHandler()->getHistory();
    }
}
