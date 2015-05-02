<?php

/*
 * HiDev
 *
 * @link      https://hiqdev.com/hidev
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hiqdev\hidev\goals;

use Yii;
use hiqdev\hidev\helpers\Inflector;
use yii\base\InvalidParamException;

/**
 * Default Goal. 'default' is reserved that's why Base
 */
class Base extends \hiqdev\collection\Manager
{

    public $goal;

    public $name;

    public $done = false;

    protected static $_knownGoals = [
        'README.md'             => 'readme',
        'README.txt'            => 'readme',
        'README.markdown'       => 'readme',
        'LICENSE.md'            => 'license',
        'LICENSE.txt'           => 'license',
        'LICENSE.markdown'      => 'license',
        'CHANGELOG.md'          => 'changelog',
        'CHANGELOG.txt'         => 'changelog',
        'CHANGELOG.markdown'    => 'changelog',
    ];

    public function getItemClass($name = null, array $config = [])
    {
        $class = static::goal2class($config['goal'],$name);

        return class_exists($class) ? $class : static::goal2class('base');
    }

    public static function goal2class($id, $name = null)
    {
        $id = $id ?: static::$_knownGoals[$name] ?: $name;

        return 'hiqdev\hidev\goals\\' . Inflector::id2camel($id);
    }

    /**
     * @inheritdoc
     */
    public function getItemConfig($name = null, array $config = [])
    {
        return array_merge([
            'class' => $this->getItemClass($name, $config),
            'name'  => $name,
        ], $config);
    }

    /**
     * Creates goal if not exists else updates.
     * This makes goals unique by name.
     *
     * @param string $name   item name.
     * @param array  $config item instance configuration.
     *
     * @return item instance.
     */
    protected function createItem($name, $config = [])
    {
        if (!is_array($config)) d("No goal $name or something else", gettype($config), $config);
        
        $item = $this->getConfig()->getRaw($name);
        if (is_object($item)) {
            $item->mset($config);
        } else {
            $item = parent::createItem($name, array_merge((array)$item, $config));
            $this->getConfig()->set($name,$item);
        }
        return $item;
    }

    public function deps()
    {
        foreach ($this->getItems() as $name => $goal) {
            if ($goal instanceof self && !$goal->done) {
                $goal->run();
            }
        }
    }

    public function run()
    {
        if ($this->done) {
            Yii::trace("Already done: $this->name");
            return;
        }
        Yii::trace("Started: $this->name");
        $this->deps();
        $this->make();
        $this->done = true;
    }

    public function make()
    {
        Yii::trace("Doing nothing for '$this->name'");
        /// throw new InvalidParamException("Don't know how to make '$this->name'");
    }


    public function getConfig()
    {
        return Yii::$app->get('config');
    }

/* XXX makes loops
    public function getPackage()
    {
        return $this->getConfig()->getItem('package');
    }

    public function getVendor()
    {
        return $this->getConfig()->getItem('vendor');
    }
*/

}
