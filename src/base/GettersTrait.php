<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\base;

use ReflectionClass;
use Yii;

/**
 * Getters trait.
 */
trait GettersTrait
{
    protected $_view;

    public function getView()
    {
        if ($this->_view === null) {
            $this->_view = $this->getApp()->getView();
        }

        return $this->_view;
    }

    public function getViewPath()
    {
        $ref = new ReflectionClass($this);

        return dirname(dirname($ref->getFileName())) . '/views';
    }

    public function takeGoal($id)
    {
        return $this->getApp()->get($id);
    }

    public function takeVendor()
    {
        return $this->getApp()->get('vendor');
    }

    public function takePackage()
    {
        return $this->getApp()->get('package');
    }

    public function takeVcs()
    {
        return $this->getApp()->get('git');
    }

    public function getApp()
    {
        return Yii::$app;
    }
}
