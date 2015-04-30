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

/**
 * Default Goal. 'default' is reserved that's why Base
 */
class Base extends \hiqdev\collection\Manager
{

    public $name;

    public $done = false;

    public function getItemClass($name = null, array $config = [])
    {
        $class = static::getGoalClass($config['goal'] ?: $name);

        return class_exists($class) ? $class : static::getGoalClass('base');
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

    public static function getGoalClass($id)
    {
        return 'hiqdev\hidev\goals\\' . Inflector::id2camel($id);
    }

    public function run()
    {
        if ($this->done) {
            return;
        }
        foreach ($this->getItems() as $name => $goal) {
            if (!$goal->done) {
                $goal->run();
            }
        }
        $this->make();
        $this->done = true;
    }

    public function make()
    {
        Yii::trace("Finished $this->name");
    }

}
