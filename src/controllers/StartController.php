<?php

/*
 * Automation tool mixed with code generator for easier continuous development
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
use yii\helpers\ArrayHelper;

/**
 * Start goal.
 * Chdirs to the project's root directory and loads dependencies and configs.
 */
class StartController extends CommonController
{
    /**
     * @var string absolute path to the project root directory
     */
    protected $_rootDir;

    /**
     * @var bool hidev already started flag
     */
    public static $started = false;

    /**
     * Make action.
     */
    public function actionMake()
    {
        $this->getRootDir();
        $this->takeConfig()->includeConfig('.hidev/config.yml');
        if (file_exists('.hidev/config-local.yml')) {
            $this->takeConfig()->includeConfig('.hidev/config-local.yml');
        }
        $this->addAliases();
        $this->addAutoloader();
        $this->requireAll();
        $this->includeAll();
        $this->loadConfig();
        self::$started = true;
    }

    public function addAutoloader()
    {
        $autoloader = Yii::getAlias('@root/vendor/autoload.php');
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
     * - @root alias to current project root dir
     * - current package namespace for it could be used from hidev.
     */
    public function addAliases()
    {
        Yii::setAlias('@root', $this->getRootDir());
        $config = $this->takeConfig()->rawItem('package');
        $alias  = strtr($config['namespace'], '\\', '/');
        if ($alias && !Yii::getAlias('@' . $alias, false)) {
            $srcdir = Yii::getAlias('@root/' . ($config['src'] ?: 'src'));
            Yii::setAlias($alias, $srcdir);
        }
        $aliases = $this->takeConfig()->rawItem('aliases');
        if (!empty($aliases) && is_array($aliases)) {
            foreach ($aliases as $alias => $path) {
                if (!$this->hasAlias($alias)) {
                    Yii::setAlias($alias, $path);
                }
            }
        }
    }

    public function hasAlias($alias, $exact = true)
    {
        $pos = strpos($alias, '/');

        return $pos === false ? isset(Yii::$aliases[$alias]) : isset(Yii::$aliases[substr($alias, 0, $pos)][$alias]);
    }

    /**
     * Require all configured requires.
     */
    protected function requireAll()
    {
        $plugins = $this->takeConfig()->rawItem('plugins');
        $vendors = [];
        if ($plugins) {
            $file = File::create('.hidev/composer.json');
            $data = ArrayHelper::merge($file->load(), ['require' => $plugins]);
            if ($file->save() || !is_dir('.hidev/vendor')) {
                $this->runAction('update');
            }
            $vendors[] = '.hidev/vendor';
        } elseif ($this->needsComposerInstall()) {
            if ($this->passthru('composer', ['install', '--ansi'])) {
                throw new InvalidParamException('Failed initialize project with composer install');
            }
        }
        if (file_exists('vendor/hiqdev/config/hidev.php')) {
            $vendors[] = 'vendor';
        }
        if (!empty($vendors)) {
            foreach (array_unique($vendors) as $dir) {
                $this->module->loadExtraVendor($dir);
            }
        }
    }

    public function needsComposerInstall()
    {
        if (file_exists('vendor')) {
            return false;
        }
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
            $this->module->loadExtraConfig($path);
        }
    }

    public function setRootDir($value)
    {
        $this->_rootDir = $value;
    }

    public function getRootDir()
    {
        if ($this->_rootDir === null) {
            $this->_rootDir = $this->findRootDir();
        }

        return $this->_rootDir;
    }

    /**
     * Chdirs to project's root by looking for config file in the current directory and up.
     * @throws InvalidParamException when failed to find
     * @return string path to the root directory of hidev project
     */
    protected function findRootDir()
    {
        $configDir = '.hidev';
        for ($i = 0;$i < 9;++$i) {
            if (is_dir($configDir)) {
                return getcwd();
            }
            chdir('..');
        }
        throw new InvalidParamException("Not a hidev project (or any of the parent directories).\nUse `hidev init` to initialize hidev project.");
    }

    public function buildRootPath($subpath)
    {
        return $this->getRootDir() . DIRECTORY_SEPARATOR . $subpath;
    }
}
