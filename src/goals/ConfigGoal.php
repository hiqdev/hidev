<?php

/*
 * HiDev - integrate your development
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hidev\goals;

use hidev\helpers\Helper;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\InvalidParamException;

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
        return $this->hasItem($name) || class_exists(static::goal2class('', $name));
    }

    public function getGoal($name)
    {
        return $this->getItem($name);
    }

    public static function findGoal($name)
    {
        return Yii::$app->pluginManager->get('goals')[$name];
    }

    public static function goal2class($id, $name = null)
    {
        $id = $id ?: static::findGoal($name) ?: $name;

        return strpos($id, '\\') !== false ? $id : 'hidev\goals\\' . Helper::id2camel($id) . 'Goal';
    }

    public function getItemClass($name = null, array $config = [])
    {
        $class = static::goal2class($config['goal'], $name);

        return class_exists($class) ? $class : static::goal2class('default');
    }

    public function getItemConfig($name = null, array $config = [])
    {
        return array_merge([
            'class'    => $this->getItemClass($name, $config),
            'goalName' => $name,
        ], $config);
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
        if (!$this->file->find($this->types)) {
            throw new InvalidParamException('No config found. Use hidev init');
        }
        if ($app->pluginManager->configFiles) {
            foreach ($app->pluginManager->configFiles as $path) {
                $file = Yii::createObject(array_merge([
                    'class' => 'hidev\base\File',
                ], is_array($path) ? $path : compact('path')));
                $this->mset($file->load());
            }
        }
        $this->actionLoad();
    }
}
