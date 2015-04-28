<?php

/*
 * Highy Integrated Development.
 *
 * @link      https://hiqdev.com/hidev
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev 
 */

namespace hiqdev\hidev\components;

use Yii;
use yii\helpers\Inflector;

/**
 * Main config.
 */
class Config extends \hiqdev\collection\Manager implements \yii\base\BootstrapInterface
{

    /**
     * @var string directory to hold config and stuff
     */
    protected static $zdir = '.hidev';

    /**
     * @var string filename of the main config file
     */
    protected static $zfile = 'config.json';

    /**
     * @var array|File file with main config
     */
    protected $_file;

    /**
     * @var array default config
     */
    protected static $_defaults = [
        'package' => [
            'type'          => 'package',
            'name'          => 'package',
            'title'         => 'Package Title',
            'license'       => 'BSD-3-clause',
            'keywords'      => ['example'],
            'description'   => 'Package Desription',
            'namespace'     => 'vendor\package',
        ],
        'vendor' => [
            'name'          => 'vendor',
            'title'         => 'Vendor',
        ],
    ];

    public function getItemClass($name)
    {
        return 'hiqdev\hidev\components\\' . Inflector::id2camel($name);
    }

    /**
     * Bootstraps config. Reads or creates if doesn't exist
     * Looks for .hidev in current directory and up.
     * 
     * @param yii\base\Application $app application
     */
    public function bootstrap($app)
    {
        $dir = getcwd();
        for ($i=0;$i<9;++$i) {
            if (file_exists(self::$zdir)) break;
            chdir('..');
        }
        if (!file_exists(self::$zdir)) {
            chdir($dir);
            mkdir(self::$zdir);
        }
        $path = getcwd() . '/' . self::$zdir . '/' . self::$zfile;
        $this->setFile($path);
        if (!$this->file->exists()) {
            $this->file->save($this);
        } else {
            $this->setItems($this->file->read());
        }
    }

    /**
     * Returns file and instantiates it with File::create.
     */
    public function getFile()
    {
        if (!is_object($this->_file)) {
            $this->_file = File::create($this->_file);
        }

        return $this->_file;
    }

    /**
     * Sets file with given info.
     *
     * @param mixed $info could be anything that is good for File::create
     */
    public function setFile($info)
    {
        $this->_file = $info;
    }
}
