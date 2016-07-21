<?php

/*
 * Automation tool mixed with code generator for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

/**
 * Controller for .gitignore files generation.
 */
class GitignoreController extends VcsignoreController
{
    public $fileType = 'gitignore';
}
