<?php

/*
 * Highy Integrated Development.
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hidev\goals;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\InvalidParamException;
use yii\base\BootstrapInterface;
use hidev\helpers\Helper;

/**
 * The Config. Keeps the Goals.
 */
class ConfigGoal extends FileGoal implements BootstrapInterface
{
    /**
     * @var array|File file with main config
     */
    protected $_file = '.hidev/config.yml';

    public $types = ['yaml', 'json'];

    protected static $_knownGoals = [
        'README.md'             => 'readme',
        'README.txt'            => 'readme',
        'README.markdown'       => 'readme',
        'LICENSE'               => 'license',
        'LICENSE.md'            => 'license',
        'LICENSE.txt'           => 'license',
        'LICENSE.markdown'      => 'license',
        'CHANGELOG.md'          => 'changelog',
        'CHANGELOG.txt'         => 'changelog',
        'CHANGELOG.markdown'    => 'changelog',
    ];

    public static function goal2class($id, $name = null)
    {
        $id = $id ?: static::$_knownGoals[$name] ?: $name;

        return 'hidev\goals\\' . Helper::id2camel($id) . 'Goal';
    }

    public function getItemClass($name = null, array $config = [])
    {
        $class = static::goal2class($config['goal'],$name);

        return class_exists($class) ? $class : static::goal2class('base');
    }

    public function save()
    {
    }

    /**
     * Bootstraps config. Reads or creates if doesn't exist
     * Looks for .hidev in current directory and up.
     *
     * @param yii\base\Application $app application
     */
    public function bootstrap($app)
    {
        for ($i=0;$i<9;++$i) {
            if (is_dir($this->dirname)) break;
            chdir('..');
        }
        if (!$this->file->find($this->types)) {
            throw new InvalidParamException('No config found. Use hidev init');
        }
        Yii::setAlias('@source', getcwd());
        Yii::setAlias('@config', '@source/' . $this->dirname);
        Yii::setAlias('@parent', '@config/parent');
        $this->load();
        $parent = $this->parent;
        if ($parent->defined) {
            if (!$parent->file->find($this->types)) {
                throw new InvalidParamException('No parent config found at ' . $parent->defined);
            }
            $parent->load();
            $parent->unsetItem('parentConfig');
            $this->_items = ArrayHelper::merge($parent->_items, $this->_items);
        }
    }

}
