<?php

/*
 * HiDev - integrate your development
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hidev\base;

use Yii;
use yii\base\ViewContextInterface;

/**
 * The Application.
 * Redefined for extending.
 */
class Application extends \yii\console\Application implements ViewContextInterface
{
    protected $_viewPath;

    public function getViewPath()
    {
        if ($this->_viewPath === null) {
            $this->_viewPath = Yii::getAlias('@parent/templates');
        }

        return $this->_viewPath;
    }

    public function createControllerByID($id)
    {
        if (!$this->config->hasGoal($id)) {
            d("Can't run goal '$id'");
        }

        return $this->config->getGoal($id);
    }

    public function runRequest($string)
    {
        $request = Yii::createObject([
            'class'  => 'hidev\base\Request',
            'params' => array_filter(explode(' ', $string)),
        ]);

        return $this->handleRequest($request);
    }
}
