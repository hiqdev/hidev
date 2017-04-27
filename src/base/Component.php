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
use yii\base\ViewContextInterface;

/**
 */
class Component extends \yii\base\Component implements ViewContextInterface
{
    public function render($view, $params = [])
    {
        return Yii::$app->getView()->render($view, array_merge([
            'module' => $this,
            'config' => Yii::$app->get('config'),
        ], $params), $this);
    }

    public function getViewPath()
    {
        die(__METHOD__);
        return '';
    }

    protected $_view;

    public function getView()
    {
        if ($this->_view === null) {
            $this->_view = Yii::$app->getView();
        }

        return $this->_view;
    }

    public function takeGoal($id)
    {
        return Yii::$app->get($id);
    }

    public function takeVendor()
    {
        return Yii::$app->get('vendor');
    }

    public function takePackage()
    {
        return Yii::$app->get('package');
    }

    public function takeVcs()
    {
        return Yii::$app->get('git');
    }
}
