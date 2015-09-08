<?php

/*
 * HiDev - integrate your development
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hidev\base;

use Yii;
use yii\base\ViewContextInterface;

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
                $main  = Yii::getAlias('@vendor/yiisoft/extensions.php');
                $local = realpath('./.hidev/vendor/yiisoft/extensions.php');
                if ($local !== $main) {
                    $this->extensions = array_merge(
                        is_file($main)  ? include($main)  : [],
                        is_file($local) ? include($local) : []
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
            d("Can't run goal '$id'");
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
}
