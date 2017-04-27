<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\base;

use hidev\base\File;
use hidev\helpers\ConfigPlugin;
use hidev\helpers\FileHelper;
use Symfony\Component\Yaml\Yaml;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;

/**
 * Application starter.
 * Chdirs to the project's root directory and loads dependencies and configs.
 *
 * XXX it's important to distinguish:
 * - goals definitions (hidev config)
 * - application config
 */
class Starter
{
    /**
     * @var string absolute path to the project root directory
     */
    private $_rootDir;

    /**
     * @var array goals definitions
     */
    private $goals = [];

    private $hidevFiles = [];

    /**
     * @var array application config files
     */
    private $appFiles = ['@hidev/config/basis.php'];

    /**
     * Make action.
     */
    public function __construct()
    {
        $this->getRootDir();
        $this->loadGoals();
        $this->addAliases();
        //  $this->addAutoloader();
        $this->requireAll();
        $this->includeAll();
        $this->moreConfig();
    }

    public function getConfig()
    {
        $config = $this->readConfig();
        /*$config = ArrayHelper::merge($this->readConfig(), [
            'modules' => $this->goals,
        ]);*/

        foreach ($config['controllerMap'] as &$def) {
            if (is_array($def) && empty($def['class'])) {
                $def['class'] = \hidev\controllers\CommonController::class;
            }
        }
        unset($config['controllerMap']['include']);
        unset($config['controllerMap']['plugins']);

        return $config;
    }

    public function readConfig()
    {
        $config = [];
        foreach ($this->appFiles as $file) {
            $path = Yii::getAlias($file);
            $config = ArrayHelper::merge($config, require $path);
        }

        return $config;
    }

    public function getGoals()
    {
        return $this->goals;
    }

    private function loadGoals()
    {
        $this->includeGoals('hidev.yml');
        if (file_exists('hidev-local.yml')) {
            $this->includeGoals('hidev-local.yml');
        }
    }

    private function includeGoals($paths)
    {
        foreach ((array)$paths as $path) {
            $this->goals = ArrayHelper::merge(
                $this->goals,
                $this->readYaml($path)
            );
        }
    }

    private function readYaml($path)
    {
        return Yaml::parse(FileHelper::read($path));
    }

    private function addAutoloader()
    {
        $autoloader = Yii::getAlias('@root/vendor/autoload.php');
        if (file_exists($autoloader)) {
            spl_autoload_unregister(['Yii', 'autoload']);
            require $autoloader;
            spl_autoload_register(['Yii', 'autoload'], true, true);
        }
    }

    /**
     * Adds aliases:
     * - @root alias to current project root dir
     * - @hidev own alias
     * - current package namespace for it could be used from hidev
     * - aliases listed in config
     */
    private function addAliases()
    {
        Yii::setAlias('@root', $this->getRootDir());
        Yii::setAlias('@hidev', dirname(__DIR__));
        $package = $this->goals['package'];
        $alias  = isset($package['namespace']) ? strtr($package['namespace'], '\\', '/') : '';
        if ($alias && !Yii::getAlias('@' . $alias, false)) {
            $srcdir = Yii::getAlias('@root/' . ($package['src'] ?: 'src'));
            Yii::setAlias($alias, $srcdir);
        }
        $aliases = $this->goals['aliases'];
        if (!empty($aliases) && is_array($aliases)) {
            foreach ($aliases as $alias => $path) {
                if (!$this->hasAlias($alias)) {
                    Yii::setAlias($alias, $path);
                }
            }
        }
    }

    private function hasAlias($alias, $exact = true)
    {
        $pos = strpos($alias, '/');

        return $pos === false ? isset(Yii::$aliases[$alias]) : isset(Yii::$aliases[substr($alias, 0, $pos)][$alias]);
    }

    /**
     * - install configured plugins and register their app config
     * - install project dependencies and register
     * - register application config files
     */
    private function requireAll()
    {
        $vendors = [];
        $plugins = $this->goals['plugins'];
        if ($plugins) {
            $file = File::create('.hidev/composer.json');
            $data = ArrayHelper::merge($file->load(), ['require' => $plugins]);
            if ($file->save($data) || !is_dir('.hidev/vendor')) {
                $this->updateDotHidev();
            }
            $vendors[] = $this->buildRootPath('.hidev/vendor');
        }
        if ($this->needsComposerInstall()) {
            if ($this->passthru('composer', ['install', '--ansi'])) {
                throw new InvalidParamException('Failed initialize project with composer install');
            }
        }
        $vendors[] = $this->buildRootPath('vendor');

        foreach ($vendors as $vendor) {
            foreach (['console', 'hidev'] as $name) {
                $path = ConfigPlugin::path($name, $vendor);
                if (file_exists($path)) {
                    $this->appFiles[] = $path;
                }
            }
        }
    }

    /**
     * Update action.
     * @return int exit code
     */
    public function updateDotHidev()
    {
        if (file_exists('.hidev/composer.json')) {
            return $this->passthru('composer', ['update', '-d', '.hidev', '--prefer-source', '--ansi']);
        }
    }

    /**
     * Passthru command.
     * @param string $command
     * @param array $args
     * @return int exit code
     */
    private function passthru($command, $args)
    {
        $binary = new BinaryPhp([
            'name' => $command,
        ]);

        return $binary->passthru($args);
    }

    private function needsComposerInstall()
    {
        if (file_exists('vendor')) {
            return false;
        }
        if (!file_exists('composer.json')) {
            return false;
        }

        return true;

    /*
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
    */
    }

    /**
     * Include all configured includes.
     */
    private function includeAll()
    {
        $config = $this->readConfig();
        $files = array_merge(
            (array)$this->goals['include'],
            (array)$config['controllerMap']['include']
        );
        $this->includeGoals($files);
    }

    /**
     * Registers more application config to load.
     */
    private function moreConfig()
    {
        $paths = $this->goals['config'];
        foreach ((array)$paths as $path) {
            if ($path) {
                $this->appFiles[] = $path;
            }
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
    private function findRootDir()
    {
        $configFile = 'hidev.yml';
        for ($i = 0; $i < 9; ++$i) {
            if (file_exists($configFile)) {
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
