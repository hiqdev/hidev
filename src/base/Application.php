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
            if ($e instanceof InvalidParamException || $e instanceof ConsoleException) {
                Yii::error($e->getMessage());
                $exitCode = 1;
            } else {
                throw $e;
            }
        }

        return $exitCode;
    }

    public static function readExtraVendor($dir)
    {
       return static::readExtraConfig($dir . '/hiqdev/extensions-config.php');
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
     * @return void
     */
    public function loadExtraVendor($dir)
    {
        $this->setExtraConfig(static::readExtraVendor($dir));
    }

    /**
     * Implements extra configuration.
     * @param array $config
     * @return void
     */
    public function setExtraConfig($config)
    {
        $this->_config = $config = ArrayHelper::merge($config, $this->_config);

        if (!empty($config['aliases'])) {
            $this->setAliases($config['aliases']);
        }
        if (!empty($config['modules'])) {
            $this->setModules($config['modules']);
        }
        if (!empty($config['components'])) {
            foreach ($config['components'] as $id => $component) {
                if ($this->has($id, true)) {
                    unset($config['components'][$id]);
                }
            }
            $this->setComponents($config['components']);
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
