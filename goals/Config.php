<?php

/*
 * Highy Integrated Development.
 *
 * @link      https://hiqdev.com/hidev
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hiqdev\hidev\goals;

use Yii;
use yii\base\InvalidParamException;
use yii\base\BootstrapInterface;
use yii\base\ViewContextInterface;
use hiqdev\hidev\helpers\Helper;

/**
 * The Config. Keeps the Goals.
 */
class Config extends File implements BootstrapInterface, ViewContextInterface
{

    /**
     * @var array|File file with main config
     */
    protected $_file = '.hidev/config.json';

    /**
     * @var array default config
     */
    protected static $_defaults = [
        'package' => [
            'type'          => 'package',
            'name'          => 'package',
            'title'         => 'Package Title',
            'license'       => 'BSD-3-Clause',
            'keywords'      => 'example',
            'description'   => 'Package Description',
            'namespace'     => 'vendor\package',
        ],
        'vendor' => [
            'name'          => 'vendor',
            'title'         => 'Vendor',
        ],
    ];

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

    public static function goal2class($id, $name = null)
    {
        $id = $id ?: static::$_knownGoals[$name] ?: $name;

        return 'hiqdev\hidev\goals\\' . Helper::id2camel($id);
    }

    public function getItemClass($name = null, array $config = [])
    {
        $class = static::goal2class($config['goal'],$name);

        return class_exists($class) ? $class : static::goal2class('base');
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
/* XXX looks like it is not needed anymore
    protected function createItem($name, $config = [])
    {
        $item = $this->getRaw($name);
        if (is_object($item)) {
            $item->mset($config);
        } else {
            $item = parent::createItem($name, array_merge((array)$item, (array)$config));
            $this->set($name,$item);
        }
        return $item;
    }
*/

    /**
     * Bootstraps config. Reads or creates if doesn't exist
     * Looks for .hidev in current directory and up.
     *
     * @param yii\base\Application $app application
     */
    public function bootstrap($app)
    {
        $start_dir = getcwd();
        for ($i=0;$i<9;++$i) {
            if (file_exists($this->dirname)) break;
            chdir('..');
        }
        if (!file_exists($this->dirname)) {
            chdir($start_dir);
            mkdir($this->dirname);
        }
        if (!$this->file->exists()) {
            throw new InvalidParamException("No config found. Use hidev init");
        }
        Yii::setAlias('@config',getcwd() . '/' . $this->dirname);
        $this->mset($this->file->load());
    }

/*
    public function setPackage($value)
    {
        return $this->setItem('package', $value);
    }

    public function setVendor($value)
    {
        return $this->setItem('vendor', $value);
    }
*/

    protected $_viewPath;

    public function getViewPath()
    {
        if ($this->_viewPath === null) {
            $this->_viewPath = Yii::$app->getBasePath() . DIRECTORY_SEPARATOR . 'views';
        }

        return $this->_viewPath;
    }
}
