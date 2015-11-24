<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (http://hiqdev.com/)
 */

namespace hidev\goals;

use hidev\helpers\Helper;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;

/**
 * The Config. Keeps config and Goals.
 */
class ConfigGoal extends FileGoal implements BootstrapInterface
{
    //protected $_itemClass = 'hiqdev\collection\Manager';

    /**
     * @param array $config name-value pairs that will be used to initialize the object properties.
     */
    public function __construct($config = [])
    {
        parent::__construct('config', Yii::$app, $config);
    }

    public $types = ['yaml', 'json'];

    public $_file = '.hidev/config.yml';

    public function hasGoal($name)
    {
        return $this->hasItem($name) || class_exists($this->getGoalClass($name));
    }

    public function getGoalClass($name)
    {
        return $this->getItemConfig($name)['class'];
    }

    public function getGoal($name)
    {
        return $this->getItem($name);
    }

    public static function findGoal($name)
    {
        $config = Yii::$app->pluginManager->get('goals')[$name];
        return is_scalar($config) ? ['class' => $config] : (array) $config;
    }

    public static function goal2class($id, $name = null)
    {
        $id = $id ?: $name;

        return strpos($id, '\\') !== false ? $id : 'hidev\goals\\' . Helper::id2camel($id) . 'Goal';
    }

    public function getItemClass($name = null, array $config = [])
    {
        $class = static::goal2class($config['goal'], $name);

        return class_exists($class) ? $class : static::goal2class('default');
    }

    public function getItemConfig($name = null, array $config = [])
    {
        $config = ArrayHelper::merge(['goalName' => $name], static::findGoal($name), $config);
        $config['class'] = $this->getItemClass($config['class'] ?: $name, $config);

        return $config;
    }

    protected function createItem($name, array $config = [])
    {
        #return Yii::createObject($this->getItemConfig($name, $config), [$name, $this->module]);
        return Yii::createObject($this->getItemConfig($name, $config), [$id, $this->module]);
    }

    public function getItem($name)
    {
        if ($name === 'default') {
            return $this;
        }
        $item = &$this->_items[$name];
        if (is_array($item) || is_null($item)) {
            $item = $this->createItem($name, $item ?: []);
        }

        return $item;
    }

    /**
     * Bootstraps config. Reads or creates if doesn't exist.
     *
     * @param yii\base\Application $app application
     */
    public function bootstrap($app)
    {
        if ($app->isInit) {
            return;
        }
        if (!$this->file->find($this->types)) {
            throw new InvalidParamException('No config found. Use hidev init vendor/package');
        }
        if ($app->pluginManager->configFiles) {
            foreach ($app->pluginManager->configFiles as $path) {
                $this->includeConfig($path);
            }
        }
        $this->actionLoad();
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
