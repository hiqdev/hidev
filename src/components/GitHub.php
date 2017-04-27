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

use yii\helpers\Json;

/**
 * GitHub component.
 */
class GitHub extends \hidev\base\Component
{
    protected $_name;
    protected $_vendor;
    protected $_description;

    /**
     * @var string GitHub OAuth access token
     */
    protected $_token;

    public function setFull_name($value)
    {
        list($this->_vendor, $this->_name) = explode('/', $value, 2);
    }

    public function getFull_name()
    {
        return $this->getVendor() . '/' . $this->getName();
    }

    public function setFullName($value)
    {
        return $this->setFull_name($value);
    }

    public function getFullName()
    {
        return $this->getFull_name();
    }

    public function setName($value)
    {
        $this->_name = $value;
    }

    public function getName()
    {
        if (!$this->_name) {
            $this->_name = $this->takePackage()->name;
        }

        return $this->_name;
    }

    public function setVendor($value)
    {
        $this->_vendor = $value;
    }

    public function getVendor()
    {
        if (!$this->_vendor) {
            $this->_vendor = $this->takeVendor()->name;
        }

        return $this->_vendor;
    }

    public function setDescription($value)
    {
        $this->_description = $value;
    }

    public function getDescription()
    {
        if ($this->_description === null) {
            $this->_description = $this->takePackage()->getTitle();
        }

        return $this->_description;
    }

}
