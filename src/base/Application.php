<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\base;

use Exception;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\console\Exception as ConsoleException;
use yii\base\Module;
use yii\base\ViewContextInterface;
use yii\helpers\ArrayHelper;

/**
 * The Application.
 */
class Application extends \yii\console\Application implements ViewContextInterface
{
    public $isInit = false;

    protected $_viewPath;

    public static function main()
    {
        try {
            Yii::setLogger(Yii::createObject('hidev\base\Logger'));
            $config = ArrayHelper::merge(
                require dirname(dirname(__DIR__)) . '/.hidev/vendor/yiisoft/yii2-extraconfig.php',
                require dirname(dirname(__DIR__)) . '/vendor/yiisoft/yii2-extraconfig.php',
                require __DIR__ . '/config.php'
            );
            # var_dump($config); die();
            foreach ($config['aliases'] as $name => $alias) {
                Yii::setAlias($name, $alias);
            }
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

    /*public function getViewPath()
    {
        if ($this->_viewPath === null) {
            $this->_viewPath = Yii::getAlias('@app/views');
        }

        return $this->_viewPath;
    }*/

    public function createControllerByID($id)
    {
        if (!$this->get('config')->hasGoal($id)) {
            var_dump("CANT RUN GOAL: $id");
            #var_dump(ArrayHelper::toArray($this->get('config')));
            throw new InvalidConfigException("can't run goal '$id'");
        }

        #var_dump( $this->get('config')->get($id) );
        return $this->get('config')->get($id);
    }

    public function runRequest($string)
    {
        $request = Yii::createObject([
            'class'  => 'hidev\base\Request',
            'params' => array_filter(explode(' ', $string)),
        ]);

        return $this->handleRequest($request);
    }

    public function runAction($route, $params = [])
    {
        try {
            return Module::runAction($route, $params);
        } catch (InvalidRouteException $e) {
            throw new Exception("Unknown command \"$route\".", 0, $e);
        }
    }
}
