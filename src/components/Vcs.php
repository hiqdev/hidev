<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\components;

/**
 * VCSs (Version Control Systems) component.
 */
class Vcs extends \hidev\base\Component
{
    protected $ignorefile;

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
            $this->_ignore = $this->take('vcsignore');
        }

        return $this->_ignore;
    }
}
