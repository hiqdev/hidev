<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

use hidev\base\File;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Controllers collection.
 * Keeps and creates controllers from configs.
 */
class Collection extends \hiqdev\yii2\collection\Object
{
    public $defaultClass = CommonController::class;
    
    protected $_included = [];

    public function hasGoal($id)
    {
        return $this->hasItem($id);
    }

    public function getItemConfig($id = null, array $config = [])
    {
        if (isset($config['class']) && $this->hasItem($config['class'])) {
            $config = array_merge($config, $this->_items[$config['class']]);
        }

        return ArrayHelper::merge([
            'class' => $this->defaultClass,
        ], $config);
    }

    public function createItem($id, $config = [])
    {
        return Yii::createObject($this->getItemConfig($id, $config), [$id, Yii::$app]);
    }

    public function getItem($id, $default = null)
    {
        $item = &$this->_items[$id];
        if (is_array($item)) {
            if (count($item) === 1 && key($item) === 'alias') {
                $item = $this->getItem($item['alias']);
            } else {
                $item = $this->createItem($id, $item);
            }
        }

        return $item;
    }

    public function getGoal($id)
    {
        return Yii::$app->createControllerById($id);
    }

    public function getVcs()
    {
        /// TODO determine VCS
        return $this->getGoal('git');
    }
}
