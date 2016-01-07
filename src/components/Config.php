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

    public function hasGoal($name)
    {
        return $this->hasItem($name);
    }

    /*public function findGoal($name)
    {
        $config = $this->getGoals()->get($name);
        return is_scalar($config) ? ['class' => $config] : (array) $config;
    }*/

    public function getItemConfig($name = null, array $config = [])
    {
        return ArrayHelper::merge([
            'goalName' => $name,
            'class'    => 'hidev\goals\DefaultGoal',
        ], $config);
    }

    protected function createItem($name, $config = [])
    {
        $config = is_scalar($config) ? ['class' => $config] : (array) $config;
        return Yii::createObject($this->getItemConfig($name, $config), [$name, Yii::$app]);
    }

    public function getItem($name)
    {
        if ($name === 'default') {
            return $this;
        }
        $item = &$this->_items[$name];
        #var_dump($item);
        #if (is_array($item) || is_null($item)) {
        if (!is_object($item)) {
            $item = $this->createItem($name, $item ?: []);
        }

        return $item;
    }

    /**
     * Loads all the configs. Reads or creates if doesn't exist.
     * @void
     */
    public function loadAllConfigs()
    {
        if (!file_exists($this->file)) {
            throw new InvalidParamException('No config found. Use hidev init vendor/package');
        }
        if (Yii::$app->get('configs')) {
            foreach (Yii::$app->get as $path) {
                $this->includeConfig($path);
            }
        }
        $this->includeConfig($this->file);
        if ($this->has('include')) {
            foreach (Helper::csplit($this->rawItem('include')) as $path) {
                $this->includeConfig($path);
            }
        }
    }

    public function includeConfig($path)
    {
        $file = Yii::createObject(array_merge([
            'class' => 'hidev\base\File',
        ], is_array($path) ? $path : compact('path')));
        $this->setItems($file->load());
    }
}
