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
 * Controller for VCSs (Version Control Systems).
 */
class VcsController extends CommonController
{
    public $lastTag = 'Under development';

    public $initTag = 'Development started';

    protected $_ignore;

    public function setIgnore($items, $where = '')
    {
        if ($items) {
            $this->getIgnore()->setItems($items, $where);
        }
    }

    public function getIgnore()
    {
        if (!is_object($this->_ignore)) {
            $this->_ignore = $this->takeGoal('vcsignore');
        }

        return $this->_ignore;
    }
}
