<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

/**
 * Controller for svn:ignore.
 */
class SvnignoreController extends VcsignoreController
{
    public $fileType = 'svnignore';
}
