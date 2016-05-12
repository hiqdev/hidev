<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\base;

use Exception;
use Yii;
use yii\base\InvalidParamException;
use yii\base\ViewContextInterface;
use yii\console\Exception as ConsoleException;
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

    /**
     * Creates application with given config and runs it.
     * @param array $config
     * @return int exit code
     */
    public static function main(array $config)
    {
        try {
            Yii::setLogger(Yii::createObject('hidev\base\Logger'));
            $config = ArrayHelper::merge(
                static::readExtraVendor($config['vendorPath']),
                $config
            );
            $exitCode = (new static($config))->run();
        } catch (Exception $e) {
            /*if ($e instanceof InvalidParamException || $e instanceof ConsoleException) {
                Yii::error($e->getMessage());
                $exitCode = 1;
            } else {
                throw $e;
            }*/
                throw $e;
        }

        return $exitCode;
    }

    public static function readExtraVendor($dir)
    {
        return static::readExtraConfig($dir . '/hiqdev/hidev-config.php');
    }

    public static function readExtraConfig($path)
    {
        return file_exists($path) ? require $path : [];
    }

    public function loadExtraConfig($path)
    {
        $this->setExtraConfig(static::readExtraConfig($path));
    }

    /**
     * Load extra config files.
     * @param array $config
     */
    public function loadExtraVendor($dir)
    {
        $this->setExtraConfig(static::readExtraVendor($dir));
    }

    /**
     * Implements extra configuration.
     * @param array $config
     */
    public function setExtraConfig($config)
    {
        $this->_config = $config = ArrayHelper::merge($config, $this->_config);

        foreach (['params', 'aliases', 'modules', 'components'] as $key) {
            if (isset($config[$key])) {
                $this->{'setExtra' . ucfirst($key)}($config[$key]);
            }
        }
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

    public function createControllerByID($id)
    {
        /// skip start for init goal
        if ($this->_first) {
            $this->_first = false;
            static $skips = ['init' => 1, 'clone' => 1, '--version' => 1];
            if (!$skips[$id]) {
                $this->runRequest('start');
            }
        }

        if ($this->get('config')->hasGoal($id)) {
            return $this->get('config')->get($id);
        }

        $controller = parent::createControllerByID($id);
        $this->get('config')->set($id, $controller);

        return $controller;
    }

    public function runRequest($string)
    {
        $request = Yii::createObject([
            'class'  => 'hidev\base\Request',
            'params' => array_filter(explode(' ', $string)),
        ]);

        return $this->handleRequest($request);
    }
}
