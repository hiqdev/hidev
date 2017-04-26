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

use hidev\helpers\ConfigPlugin;
use Yii;
use yii\base\ViewContextInterface;
use yii\helpers\ArrayHelper;

/**
 * The Application.
 */
class Application extends \yii\console\Application implements ViewContextInterface
{
    protected $_viewPath;

    protected $_config;

    protected $_first = true;

    public function __construct($config = [])
    {
        $this->_config = $config;
        parent::__construct($config);
    }

    public function loadExtraConfig($path)
    {
        $this->setExtraConfig(static::readConfig($path));
    }

    public static function readConfig($path)
    {
        $path = Yii::getAlias($path);

        return file_exists($path) ? require $path : [];
    }

    /**
     * Load extra config files.
     * @param string $vendor path to vendor dir
     */
    public function loadExtraVendor($vendor)
    {
        $this->setExtraEnv(static::readVendorConfig($vendor, 'dotenv'));
        $this->setExtraConfig(static::readVendorConfig($vendor, 'hidev'));
    }

    public function readVendorConfig($vendor, $name)
    {
        return static::readConfig(ConfigPlugin::path($name, $vendor));
    }

    /**
     * Sets extra environment variables.
     * @param array $config
     */
    public function setExtraEnv($vars)
    {
        foreach ($vars as $key => $value) {
            $_ENV[$key] = $value;
        }
    }

    /**
     * Implements extra configuration.
     * @param array $config
     */
    public function setExtraConfig($config)
    {
        $this->_config = $config = ArrayHelper::merge($config, $this->_config);
        $backup = $this->get('config')->getItems();
        $this->clear('config');

        foreach (['params', 'aliases', 'modules', 'components', 'container'] as $key) {
            if (isset($config[$key])) {
                $this->{'setExtra' . ucfirst($key)}($config[$key]);
            }
        }

        $this->get('config')->mergeItems($backup);
    }

    /**
     * Implements extra params.
     * @param array $params
     */
    public function setExtraParams($params)
    {
        if (is_array($params) && !empty($params)) {
            $this->params = ArrayHelper::merge($this->params, $params);
        }
    }

    /**
     * Implements extra aliases.
     * @param array $aliases
     */
    public function setExtraAliases($aliases)
    {
        if (is_array($aliases) && !empty($aliases)) {
            $this->setAliases($aliases);
        }
    }

    /**
     * Implements extra modules.
     * @param array $modules
     */
    public function setExtraModules($modules)
    {
        if (is_array($modules) && !empty($modules)) {
            $this->setModules($modules);
        }
    }

    /**
     * Implements extra components.
     * Does NOT touch already instantiated components.
     * @param array $components
     */
    public function setExtraComponents($components)
    {
        if (is_array($components) && !empty($components)) {
            foreach ($components as $id => $component) {
                if ($this->has($id, true)) {
                    unset($components[$id]);
                }
            }
            $this->setComponents($components);
        }
    }

    /**
     * Implements extra container config.
     * @param array $container config
     */
    public function setExtraContainer($container)
    {
        $this->setContainer($container);
    }

    public function createControllerByID($id)
    {
        /*
        if ($this->_first) {
            $this->_first = false;
            static $skips = ['init' => 1, 'clone' => 1, '--version' => 1];
            if (!isset($skips[$id])) {
                $this->runRequest('start');
            }
        }
        */

        if ($this->get('config')->hasGoal($id)) {
            return $this->get('config')->get($id);
        }

        $controller = parent::createControllerByID($id);
        $this->get('config')->set($id, $controller);

        return $controller;
    }

    /**
     * Run request.
     * @param string|array $query
     * @return Response
     */
    public function runRequest($query)
    {
        $request = Yii::createObject([
            'class'  => 'hidev\base\Request',
            'params' => is_array($query) ? $query : array_filter(explode(' ', $query)),
        ]);

        return $this->handleRequest($request);
    }
}
