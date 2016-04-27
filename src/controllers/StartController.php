<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

use hidev\base\File;
use Yii;
use yii\base\InvalidParamException;

/**
 * Start goal.
 * Chdirs to the project's root directory and loads dependencies and configs.
 */
class StartController extends CommonController
{
    const MAIN_CONFIG = '.hidev/config.yml';

    /**
     * @var string absolute path to the project root directory
     */
    public $prjdir;

    /**
     * @var bool hidev already started flag
     */
    public static $started = false;

    /**
     * Make action.
     */
    public function actionMake()
    {
        $this->getPrjDir();
        $this->takeConfig()->includeConfig(static::MAIN_CONFIG);
        $this->addAliases();
        $this->addAutoloader();
        $this->requireAll();
        $this->includeAll();
        $this->loadConfig();
        self::$started = true;
    }

    public function addAutoloader()
    {
        $autoloader = Yii::getAlias('@prjdir/vendor/autoload.php');
        if (file_exists($autoloader)) {
            spl_autoload_unregister(['Yii', 'autoload']);
            require $autoloader;
            spl_autoload_register(['Yii', 'autoload'], true, true);
        }
    }

    /**
     * Update action.
     * @return int exit code
     */
    public function actionUpdate()
    {
        return $this->passthru('composer', ['update', '-d', '.hidev', '--prefer-source', '--ansi']);
    }

    /**
     * Adds aliases:
     * - @prjdir alias to current project root dir
     * - current package namespace for it could be used from hidev.
     */
    public function addAliases()
    {
        Yii::setAlias('@prjdir', $this->getPrjDir());
        $config = $this->takeConfig()->rawItem('package');
        $alias  = strtr($config['namespace'], '\\', '/');
        if ($alias && !Yii::getAlias('@' . $alias, false)) {
            $srcdir = Yii::getAlias('@prjdir/' . ($config['src'] ?: 'src'));
            Yii::setAlias($alias, $srcdir);
        }
    }

    /**
     * Require all configured requires.
     */
    protected function requireAll()
    {
        $plugins = $this->takeConfig()->rawItem('plugins');
        $vendors = [];
        if ($plugins) {
            $saved = File::create('.hidev/composer.json')->save(['require' => $plugins]);
            if ($saved || !is_dir('.hidev/vendor')) {
                $this->runAction('update');
            }
            $vendors[] = '.hidev/vendor';
        } elseif ($this->hasPluginsInController()) {
            if (!file_exists('vendor')) {
                return $this->passthru('composer', ['install', '--ansi']);
            }
        }
        if (file_exists('vendor/hiqdev')) {
            $vendors[] = 'vendor';
        }
        if (!empty($vendors)) {
            /// backup config then reset with extra config then restore
            $config = $this->takeConfig()->getItems();
            Yii::$app->clear('config');
            foreach (array_unique($vendors) as $dir) {
                Yii::$app->loadExtraVendor($dir);
            }
            $this->takeConfig()->mergeItems($config);
        }
    }

    public function hasPluginsInController()
    {
        if (!file_exists('composer.json')) {
            return false;
        }
        $data = File::create('composer.json')->load();
        foreach (['require', 'require-dev'] as $key) {
            if (isset($data[$key])) {
                foreach ($data[$key] as $package => $version) {
                    list(, $name) = explode('/', $package);
                    if (strncmp($name, 'hidev-', 6) === 0) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Include all configs.
     */
    public function includeAll()
    {
        $still = true;
        while ($still) {
            $still = false;
            $include = $this->takeConfig()->rawItem('include');
            if ($include) {
                foreach ($include as $path) {
                    $still = $still || $this->takeConfig()->includeConfig($path);
                }
            }
        }
    }

    /**
     * Load project's config if configured.
     */
    public function loadConfig()
    {
        $path = $this->takeConfig()->rawItem('config');
        if ($path) {
            Yii::$app->loadExtraConfig($path);
        }
    }

    public function getPrjDir()
    {
        if ($this->prjdir === null) {
            $this->prjdir = $this->findPrjDir();
        }

        return $this->prjdir;
    }

    /**
     * Chdirs to project's root by looking for config file in the current directory and up.
     * @throws InvalidParamException when failed to find
     * @return string path to the root directory of hidev project
     */
    protected function findPrjDir()
    {
        $configDir = '.hidev';
        for ($i = 0;$i < 9;++$i) {
            if (is_dir($configDir)) {
                $this->prjdir = getcwd();
                return $this->prjdir;
            }
            chdir('..');
        }
        throw new InvalidParamException("Not a hidev project (or any of the parent directories).\nUse `hidev init` to initialize hidev project.");
    }
}
