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

use Yii;

/**
 * Goal for VCS (Version Control Systems).
 */
class VcsGoal extends DefaultGoal
{
    public $lastTag = 'Under development';

    public $initTag = 'Development started';

    public function setIgnore($items, $where = '')
    {
        $this->getIgnore()->setItems($items, $where);
    }

    protected $_ignore;

    public function getIgnore()
    {
        if (!is_object($this->_ignore)) {
            $this->_ignore = $this->getConfig()->get('vcsignore');
        }

        return $this->_ignore;
    }
}
