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

    public function take($id)
    {
        return $this->getApp()->get($id);
    }

    public function getApp()
    {
        return Yii::$app;
    }
}
