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
use hiqdev\hidev\helpers\Helper;

/**
 * The Config. Keeps the Goals.
 */
class Config extends File implements BootstrapInterface
{

    /**
     * @var array|File file with main config
     */
    protected $_file = '.hidev/config.json';

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

    public function make()
    {
        Base::make();
    }

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


}
