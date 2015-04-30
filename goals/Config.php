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


    protected $_viewPath;

    public function getViewPath()
    {
        if ($this->_viewPath === null) {
            $this->_viewPath = Yii::$app->getBasePath() . DIRECTORY_SEPARATOR . 'views';
        }

        return $this->_viewPath;
    }
}
