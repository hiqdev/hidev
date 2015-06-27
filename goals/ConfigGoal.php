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
use yii\helpers\ArrayHelper;

/**
 * The Config. Keeps the Goals.
 */
class ConfigGoal extends FileGoal implements BootstrapInterface
{
    /**
     * @param array $config name-value pairs that will be used to initialize the object properties.
     */
    public function __construct($config = [])
    {
        parent::__construct('config', Yii::$app, $config);
    }

    /**
     * @var array|File file with main config
     */
    protected $_file = '.hidev/config.yml';

    public $types = ['yaml', 'json'];

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
            'class'     => $this->getItemClass($name, $config),
            'goalName'  => $name,
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
     * Looks for .hidev in current directory and up.
     *
     * @param yii\base\Application $app application
     */
    public function bootstrap($app)
    {
        for ($i = 0;$i < 9;++$i) {
            if (is_dir($this->dirname)) {
                break;
            }
            chdir('..');
        }
        if (!$this->file->find($this->types)) {
            throw new InvalidParamException('No config found. Use hidev init');
        }
        Yii::setAlias('@source', getcwd());
        Yii::setAlias('@config', '@source/' . $this->dirname);
        Yii::setAlias('@parent', '@config/parent');
        $this->actionLoad();
        $parent = $this->parent;
        if ($parent->defined) {
            if (!$parent->file->find($this->types)) {
                throw new InvalidParamException('No parent config found at ' . $parent->defined);
            }
            $parent->actionLoad();
            $parent->unsetItem('parentConfig');
            $this->_items = ArrayHelper::merge($parent->_items, $this->_items);
        }
    }
}
