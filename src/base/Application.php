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

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Module;
use yii\base\ViewContextInterface;
use yii\helpers\ArrayHelper;

/**
 * The Application.
 * Redefined for extending.
 */
class Application extends \yii\console\Application implements ViewContextInterface
{
    public $isInit = false;

    protected $_viewPath;

    protected function bootstrap()
    {
        if (!$this->isInit) {
            $require = Yii::createObject([
                'class' => 'hidev\base\File',
                'path'  => '.hidev/config.yml',
            ])->load()['require'];
            if ($require) {
                Yii::createObject([
                    'class' => 'hidev\base\File',
                    'path'  => '.hidev/composer.json',
                ])->save(compact('require'));
                if (!is_dir('.hidev/vendor')) {
                    exec('cd .hidev;composer update --prefer-source');
                }
                $main  = Yii::getAlias('@vendor');
                $local = realpath('./.hidev/vendor');
                if ($local !== $main) {
                    $this->extensions = array_merge(
                        $this->prepareExtensions($main),
                        $this->prepareExtensions($local)
                    );
                }
            }
        }
        parent::bootstrap();
    }

    public function getViewPath()
    {
        if ($this->_viewPath === null) {
            $this->_viewPath = Yii::getAlias('@app/views');
        }

        return $this->_viewPath;
    }

    public function createControllerByID($id)
    {
        if (!$this->config->hasGoal($id)) {
            var_dump(ArrayHelper::toArray($this->config));
            var_dump(ArrayHelper::toArray(Yii::$app->pluginManager));
            throw new InvalidConfigException("can't run goal '$id'");
        }

        return $this->config->getGoal($id);
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
