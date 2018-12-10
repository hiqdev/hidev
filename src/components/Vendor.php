<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hidev\components;

use hidev\helpers\Helper;

/**
 * Vendor part of the config.
 */
class Vendor extends \hidev\base\Component
{
    public $name;
    public $homepage;
    public $license;
    public $github;
    public $forum;
    public $email;
    public $authors = [];

    protected $_label;
    protected $_title;
    protected $_description;

    public function getLabel()
    {
        return $this->_label ?: ucfirst($this->name);
    }

    public function setTitle(string $title): self
    {
        $this->_title = $title;

        return $this;
    }

    public function getTitle()
    {
        return $this->_title ?: $this->_description ?: Helper::titleize($this->name);
    }

    public function getTitleAndHomepage()
    {
        return $this->title . ($this->homepage ? ' (' . $this->homepage . ')' : '');
    }

    public function getDescription()
    {
        return $this->_description ?: $this->getTitle();
    }
}
