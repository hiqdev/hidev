<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\components;

use hidev\base\File;
use hidev\helpers\Helper;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;

/**
 * The Config. Keeps config and Goals.
 */
class Config extends \hiqdev\yii2\collection\Object
{
    public $file = '.hidev/config.yml';

    protected $_included = [];

    public function hasGoal($id)
    {
        return $this->hasItem($id);
    }

    /*public function findGoal($id)
    {
        $config = $this->getGoals()->get($id);
        return is_scalar($config) ? ['class' => $config] : (array) $config;
    }*/

    public function getItemConfig($id = null, array $config = [])
    {
    var_dump($config); die('getItemConfig');
        return ArrayHelper::merge([
            'class' => 'hidev\controllers\CommonController',
        ], $config);
    }

    protected function createItem($id, $config = [])
    {
        return Yii::createObject($this->getItemConfig($id, $config), [$id, $this->module]);
    }

    public function getItem($id)
    {
        $item = &$this->_items[$id];
        #var_dump($item);
        #if (is_array($item) || is_null($item)) {
        if (is_array($item)) {
            $item = $this->createItem($id, $item);
        }

        return $item;
    }

    /**
     * Include config file, unique only.
     * @param string|array $path
     * @return bool true if the path was unique and loaded
     */
    public function includeConfig($path)
    {
        $file = File::create($path);
        $path = $file->getPath();
        if (!isset($this->_included[$path])) {
            $this->_included[$path] = $path;
            $this->setItems($file->load());
            return true;
        }

        return false;
    }
}
